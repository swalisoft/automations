#!/bin/bash

ranIn=$(echo $PWD);
cd $(dirname ${BASH_SOURCE[0]});

source logger.sh;
source utils.sh;

path='../src/Backoffice';

output_read 'Enter the module name[User]: ' auxModule;

rawModule=$(echo $auxModule | tr A-Z a-z);
rawModules=$(get_plural_name $rawModule)
module=$(parse_field_name $rawModule)
modules=$(get_plural_name $module)

moduleVar=$(parse_field_name $rawModule 1)

modulePath="$path/$modules";

fields=();
fieldTypes=();

while :
do
	output_read "Enter field name[created_at](enter to quit): " field

	if [ -z $field ]
	then
		break
	fi

  fields+=( $field );

	echo -e '';	
	output_info "1. Interger";
	output_info "2. String";
	output_info "3. Boolean";
	output_info "4. Float";
	output_info "5. DateTime";

	output_read "Choose the field type: " fieldType

  fieldTypes+=( $fieldType );
done

source infrastructure.sh
source domain.sh
source application.sh
# source controller.sh

cd $ranIn;
