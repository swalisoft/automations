#!/bin/bash

set -e

get_object_type () {

	case ${1} in
		1) name='IntValueObject';;
		2) name='StringValueObject';;
		3) name='BoolValueObject';;
		4) name='FloatValueObject';;
		5) name='DateTimeValueObject';;
	esac

  echo $name;
}

get_plural_name () {
	size=${#1};

	case ${1} in
		*y) name="${1:0:(size - 1)}ies";;
		*[szx]) name="$1es";;
		*sh) name="$1es";;
		*ch) name="$1es";;
		*) name="$1s";;
	esac

  echo $name;
}

get_php_type () {

	case ${1} in
		1) name='int';;
		2) name='string';;
		3) name='bool';;
		4) name='float';;
		5) name='DateTime';;
	esac

  echo $name;
}

get_type_name () {

	case ${1} in
		1) name='Interger';;
		2) name='String';;
		3) name='Boolean';;
		4) name='Float';;
		5) name='DateTime';;
	esac

	if [ -z $2 ]
	then
		name=$(echo $name | tr A-Z a-z);
	fi

  echo $name;
}

parse_field_name () {

	case ${2} in
		1) 
			arrField=(${1//_/ });
			name='';

			for el in ${arrField[@]};
			do
				name+=${el^};
			done

			name=${name~};

			;;
		*)
			arrField=(${1//_/ });
			name='';

			for el in ${arrField[@]};
			do
				name+=${el^};
			done

			;;
	esac

  echo $name;
}

build_template () {

	templatePath=$1;
	labels=$2;
	values=$3;
	targetPath=$4;

	template=$(cat templates/$templatePath);

	for i in ${!labels[@]}
	do
		template=${template//"%${labels[i]}%"/${values[i]}};
	done

	echo -e "$template" > $targetPath;
	output_success "Created: $targetPath" 
}
