module SudokuSolver
  ( Literal(..)
  , Clause(..)
  , Form(..)
  , Clue
  , solveSudoku
  , verificarSolucion
  , verifySudoku
  ) where

import Data.List (delete, sortOn)

-- =====================================================================
-- 1. Representación de Fórmulas en CNF (Forma Normal Conjuntiva)
-- =====================================================================

data Literal atom = P atom | N atom deriving (Eq, Read, Show)

newtype Clause atom = Or [Literal atom] 

newtype Form atom = And [Clause atom] 

-- =====================================================================
-- 2. Algoritmo DPLL con Priorización (Propagación de Unidades)
-- =====================================================================

-- | Simplificación de una lista de cláusulas asumiendo que un literal es verdadero.
(<<) :: Eq atom => [Clause atom] -> Literal atom -> [Clause atom]
cs << l = [Or (neg l `delete` ls)
           | Or ls <- cs, l `notElem` ls ]

-- | Negación de un literal.
neg :: Literal atom -> Literal atom
neg (P a) = N a
neg (N a) = P a 

-- | Algoritmo DPLL optimizado con priorización recursiva.
dpll :: Eq atom => Form atom -> [[Literal atom]]
dpll f =
  case prioritise f of
    []             -> [[]] -- Solución trivial
    Or [] : cs     -> []   -- No hay solución
    Or (l:ls) : cs ->  
      [ l : ls' | ls' <- dpll $ And (cs << l)]
      ++
      [neg l : ls' | ls' <- dpll $ And (Or ls : cs << neg l)]

-- | Ordena las cláusulas por tamaño (las más cortas primero) para priorizar unit clauses.
prioritise :: Form atom -> [Clause atom]
prioritise (And cs) = sortOn (\(Or ls) -> length ls) cs 

-- =====================================================================
-- 3. Operadores Auxiliares y Reglas del Sudoku
-- =====================================================================

-- | Conjunción de dos fórmulas CNF.
(<&&>) :: Form a -> Form a -> Form a
And xs <&&> And ys = And (xs ++ ys)

-- | Cada celda (i, j) debe contener al menos un dígito de 1 a 9.
allFilled :: Form (Int, Int, Int)
allFilled = And [ Or [ P (i, j, n) | n <- [1..9] ]
                | i <- [1..9], j <- [1..9] ]

-- | Ninguna celda contiene dos dígitos a la vez.
noneFilledTwice :: Form (Int, Int, Int)
noneFilledTwice = And [ Or [ N (i, j, n), N (i, j, n') ]
                      | i <- [1..9], j <- [1..9],
                        n <- [1..9], n' <- [1..(n-1)]]

-- | Cada fila contiene todos los dígitos del 1 al 9.
rowsComplete :: Form (Int, Int, Int)
rowsComplete = And [ Or [ P (i, j, n) | j <- [1..9] ]
                   | i <- [1..9], n <- [1..9] ]

-- | Cada fila no contiene dígitos repetidos.
rowsNoRepetition :: Form (Int, Int, Int)
rowsNoRepetition = And [ Or [ N (i, j, n), N (i, j', n) ]
                       | i <- [1..9], n <- [1..9],
                         j <- [1..9], j' <- [1..(j-1)] ]

-- | Cada columna contiene todos los dígitos del 1 al 9.
columnsComplete :: Form (Int, Int, Int)
columnsComplete = And [ Or [ P (i, j, n) | i <- [1..9] ]
                      | j <- [1..9], n <- [1..9] ] 

-- | Cada columna no contiene dígitos repetidos.
columnsNoRepetition :: Form (Int, Int, Int)
columnsNoRepetition = And [ Or [ N (i, j, n), N (i', j, n) ]
                          | j <- [1..9], n <- [1..9],
                            i <- [1..9], i' <- [1..(i-1)] ]

-- | Cada cuadrante de 3x3 contiene todos los dígitos del 1 al 9.
squaresComplete :: Form (Int, Int, Int)
squaresComplete = And [ Or [ P (3*r + i, 3*c + j, n) | i <- [1..3], j <- [1..3] ]
                      | r <- [0..2], c <- [0..2], n <- [1..9] ]

-- | Cada cuadrante de 3x3 no contiene dígitos repetidos.
squaresNoRepetition :: Form (Int, Int, Int)
squaresNoRepetition = And [ Or [ N (3*r + i, 3*c + j, n), N (3*r + i', 3*c + j', n) ]
                          | i <- [1..3], j <- [1..3], i' <- [1..3], j' <- [1..3],
                            (i, j) < (i', j'),
                            r <- [0..2], c <- [0..2],
                            n <- [1..9] ]

-- =====================================================================
-- 4. Verificación de Soluciones
-- =====================================================================

verificarSolucion :: Eq atom => Form atom -> [Literal atom] -> Bool
verificarSolucion (And cs) asignacion = all evaluarClausula cs
  where
    evaluarClausula (Or ls) = any evaluarLiteral ls
    evaluarLiteral (P atom) = P atom `elem` asignacion
    evaluarLiteral (N atom) = P atom `notElem` asignacion

-- =====================================================================
-- 5. Lógica del Solucionador Dinámico
-- =====================================================================

type Clue = (Int, Int, Int)

makeSudokuProblem :: [Clue] -> Form (Int, Int, Int)
makeSudokuProblem clues = And [ Or [P (f, c, v)] | (f, c, v) <- clues ]

solveSudoku :: [Clue] -> [[Literal (Int, Int, Int)]]
solveSudoku clues =
  let rules = allFilled <&&> noneFilledTwice <&&> rowsComplete
              <&&> columnsComplete <&&> squaresComplete
              <&&> rowsNoRepetition <&&> columnsNoRepetition
              <&&> squaresNoRepetition
      problem = makeSudokuProblem clues
      sudokuForm = rules <&&> problem
  in dpll sudokuForm

verifySudoku :: [[Int]] -> Bool
verifySudoku grid =
  let clues = [ (r, c, val)
              | (r, row) <- zip [1..9] grid
              , (c, val) <- zip [1..9] row
              , val >= 1 && val <= 9
              ]
      assignment = [ P (r, c, val) | (r, c, val) <- clues ]
      rules = allFilled <&&> noneFilledTwice <&&> rowsComplete
              <&&> columnsComplete <&&> squaresComplete
              <&&> rowsNoRepetition <&&> columnsNoRepetition
              <&&> squaresNoRepetition
  in length assignment == 81 && verificarSolucion rules assignment
