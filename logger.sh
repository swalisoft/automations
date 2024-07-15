#!/bin/bash

set -e

output () {
  echo -e "$(tput setaf $2)${1}$(tput sgr0)";
}

output_read () {
  echo;
  read -p "$(tput setaf 6)${1}$(tput sgr0)" ${2};
}

output_info () {
  output "${1}" 4;
}

output_success () {
  output "${1}" 2;
}

output_warning () {
  output "${1}" 3;
}

output_error () {
  output "${1}" 1;
}
