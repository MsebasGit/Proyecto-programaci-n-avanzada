module Main where

import System.Environment (getArgs)
import System.Exit (exitFailure)
import Text.ParserCombinators.ReadP
import Data.Char (isDigit)
import Data.List (intercalate)
import SudokuSolver (Literal(..), Clue, solveSudoku, verifySudoku)

-- =====================================================================
-- 1. Parsers JSON minimalistas con ReadP (Sin dependencias externas)
-- =====================================================================

numberP :: ReadP Int
numberP = do
  digits <- munch1 isDigit
  return (read digits)

clueP :: ReadP Clue
clueP = do
  skipSpaces
  char '{'
  kvs <- sepBy (do
    skipSpaces
    k <- choice [string "\"f\"", string "\"c\"", string "\"v\""]
    skipSpaces
    char ':'
    skipSpaces
    v <- numberP
    return (init (tail k), v)
    ) (char ',')
  skipSpaces
  char '}'
  let getVal key list = case lookup key list of
                          Just val -> val
                          Nothing  -> error $ "Key not found: " ++ key
  return (getVal "f" kvs, getVal "c" kvs, getVal "v" kvs)

cluesP :: ReadP [Clue]
cluesP = do
  skipSpaces
  char '['
  clues <- sepBy clueP (char ',')
  skipSpaces
  char ']'
  skipSpaces
  eof
  return clues

parseClues :: String -> [Clue]
parseClues input =
  case readP_to_S cluesP input of
    ((clues, _):_) -> clues
    _ -> error "Failed to parse clues JSON"

matrixP :: ReadP [[Int]]
matrixP = do
  skipSpaces
  char '['
  rows <- sepBy (do
    skipSpaces
    char '['
    cols <- sepBy (do
      skipSpaces
      numberP
      ) (char ',')
    skipSpaces
    char ']'
    return cols
    ) (char ',')
  skipSpaces
  char ']'
  skipSpaces
  eof
  return rows

parseMatrix :: String -> [[Int]]
parseMatrix input =
  case readP_to_S matrixP input of
    ((matrix, _):_) -> matrix
    _ -> error "Failed to parse board JSON"

-- =====================================================================
-- 2. Formateador JSON para la solución
-- =====================================================================

formatSolvedJson :: [Literal (Int, Int, Int)] -> String
formatSolvedJson sol =
  let solvedCells = [ (i, j, n) | P (i, j, n) <- sol ]
      getDigit i j = case filter (\(r, c, _) -> r == i && c == j) solvedCells of
                       [(_, _, n)] -> show n
                       _           -> "0"
      formatRow i = "[" ++ intercalate "," [ getDigit i j | j <- [1..9] ] ++ "]"
      rows = [ formatRow i | i <- [1..9] ]
  in "[" ++ intercalate "," rows ++ "]"

-- =====================================================================
-- 3. Punto de entrada
-- =====================================================================

main :: IO ()
main = do
  args <- getArgs
  case args of
    ["solve", jsonInput] -> do
      let clues = parseClues jsonInput
      let soluciones = solveSudoku clues
      case soluciones of
        (sol:_) -> putStrLn (formatSolvedJson sol)
        []      -> do
          putStrLn "No solution found"
          exitFailure
    ["verify", jsonInput] -> do
      let grid = parseMatrix jsonInput
      if verifySudoku grid
        then do
          putStrLn "valid"
        else do
          putStrLn "invalid"
          exitFailure
    _ -> do
      putStrLn "Usage: solucionador_sudoku solve '<json_clues>' | verify '<json_board>'"
      exitFailure
