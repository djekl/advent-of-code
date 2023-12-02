#!/usr/bin/env bash

# set the year
YEAR=$(date +%Y)

# ask for the day number
# and validate this is a valid number
while :; do
    echo What is todays calendar task number?
    read DAY

    [[ $DAY =~ ^[0-9]+$ ]] || { printf "\033[0;31mERROR:\033[0m Enter a valid number \n\n"; continue; }
    if ((DAY >= 0 && DAY <= 25)); then
        printf "\033[0;32mSUCCESS:\033[0m Generating files for ${YEAR} Day ${DAY} \n\n"
        break
    else
        printf "\033[0;31mERROR:\033[0m Number out of range, please try again \n\n"
    fi
done

# validate this days file doesn't exist
if test -f ./${YEAR}/days/${DAY}.php; then
  printf "./${YEAR}/days/${DAY}.php\n"
  printf "\033[0;31mERROR:\033[0m This days files already exist! \n\n"
  exit 1
fi

# make our input file dir
mkdir -p ./${YEAR}/inputs/day-${DAY}
printf "\033[0;32mDIRECTORY:\033[0m ./${YEAR}/inputs/day-${DAY} \n"

# create our empty input files
touch ./${YEAR}/inputs/day-${DAY}/input.txt
printf "\033[0;32mFILE:\033[0m ./${YEAR}/inputs/day-${DAY}/input.txt \n"

touch ./${YEAR}/inputs/day-${DAY}/part-1-example.txt
printf "\033[0;32mFILE:\033[0m ./${YEAR}/inputs/day-${DAY}/part-1-example.txt \n"

touch ./${YEAR}/inputs/day-${DAY}/part-2-example.txt
printf "\033[0;32mFILE:\033[0m ./${YEAR}/inputs/day-${DAY}/part-2-example.txt \n"

# generate our php file for today
cat << EOF > ./${YEAR}/days/${DAY}.php
<?php

namespace AOC${YEAR}\Day${DAY};

function part1(string \$input): int
{
    //
}

check('${YEAR} Day ${DAY} Part 1 Example', '${YEAR}/inputs/day-${DAY}/part-1-example.txt', part1(...), null);
// produce('${YEAR} Day ${DAY} Part 1', '${YEAR}/inputs/day-${DAY}/input.txt', part1(...));

// function part2(string \$input): int
// {
//     //
// }

// check('${YEAR} Day ${DAY} Part 2 Example', '${YEAR}/inputs/day-${DAY}/part-2-example.txt', part2(...), null);
// produce('${YEAR} Day ${DAY} Part 2', '${YEAR}/inputs/day-${DAY}/input.txt', part2(...));
EOF
printf "\033[0;32mFILE:\033[0m ./${YEAR}/days/${DAY}.php \n\n"

# success message
printf "\033[0;32mSUCCESS:\033[0m All files generated! \n\n"

# open todays challenge
open https://adventofcode.com/${YEAR}/day/${DAY}

# open todays files in phpstorm
open -a "PhpStorm" ./${YEAR}/days/${DAY}.php
open -a "PhpStorm" ./${YEAR}/inputs/day-${DAY}/input.txt
open -a "PhpStorm" ./${YEAR}/inputs/day-${DAY}/part-1-example.txt
