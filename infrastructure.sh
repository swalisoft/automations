mkdir -p $modulePath/Infrastructure/Persistence/Mappings;

xmlFields='';

for i in ${!fields[@]};
do

  field=$(echo ${fields[i]} | tr A-Z a-z);
  fieldType=${fieldTypes[$i]}
	fileName="$module$(parse_field_name $field)";

	if [ $field == id ]
	then
		relative="/Infrastructure/Persistence/Mappings/${module}IdType.php"; 

		template='Infrastructure/ModuleIdType.php';
		labels=('module' 'modules' 'rawModule');
		values=($module $modules $rawModule);

		build_template $template $labels $values "$modulePath/$relative" 

		xmlFields+="
		<id
			name=\"id\"
			type=\"${rawModule}_id\"
			column=\"id\"
			length=\"36\"
		/>";
	elif [[ $field =~ .*id$ ]]
	then
		xmlFields+="
		<field
			name=\"$(parse_field_name $field 1)\"
			type=\"$field\"
			column=\"$field\"
			length=\"36\"
		/>";
	else
		relative="/Infrastructure/Persistence/Mappings/$fileName.orm.xml"; 

		template='Infrastructure/ModuleField.orm.xml';
		labels=('modules' 'fileName' 'fieldType' 'field');
		values=($modules $fileName $(get_type_name $fieldType) $field);

		build_template $template $labels $values "$modulePath/$relative"; 

		xmlFields+="
		<embedded
			name=\"$(parse_field_name $field 1)\"
			class=\"Seavices\Backoffice\\$modules\Domain\\$fileName\"
			use-column-prefix=\"false\"
		/>";
	fi
done

#--- Schema Read ---#
relative="/Infrastructure/Persistence/Mappings/${module}Read.orm.xml"; 

template='Infrastructure/ModuleRead.orm.xml';
labels=('module' 'modules' 'rawModules' 'xmlFields');
values=($module $modules $rawModules "$xmlFields");

build_template $template $labels $values "$modulePath/$relative" 

#--- Schema Write ---#
relative="/Infrastructure/Persistence/Mappings/${module}Write.orm.xml"; 

template='Infrastructure/ModuleWrite.orm.xml';
labels=('module' 'modules' 'rawModules' 'xmlFields');
values=($module $modules $rawModules "$xmlFields");

build_template $template $labels $values "$modulePath/$relative" 

#--- Repository Read ---#
relative="/Infrastructure/Persistence/MySql${module}RepositoryRead.php"; 

template='Infrastructure/MySqlModuleRepositoryRead.php';
labels=('module' 'modules');
values=($module $modules);

build_template $template $labels $values "$modulePath/$relative" 

#--- Repository Write ---#
relative="/Infrastructure/Persistence/MySql${module}RepositoryWrite.php"; 

template='Infrastructure/MySqlModuleRepositoryWrite.php';
labels=('module' 'modules' 'rawModule');
values=($module $modules $rawModule);

build_template $template $labels $values "$modulePath/$relative" 

output_success "\nFinished Infrastructure created...\n" 
