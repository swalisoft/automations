# --------- Application ---------

mkdir -p $modulePath/Application/{Create,Find,Update,SearchAll,Delete,};

p_attributes='';
p_getters='';
assignValue='';
p_params='';
uses='';
createResponse='';
toArray='';

for i in ${!fields[@]};
do

  field=$(echo ${fields[i]} | tr A-Z a-z);
  fieldType=${fieldTypes[$i]}
	varType=$(get_php_type $fieldType)
	varName=$(parse_field_name $field 1);

	if [ $fieldType == 5 ] && [ -z $includedDateTime]
	then
		uses+='use DateTime;';

		includedDateTime=1
	fi

	p_attributes+="
		private \$$varName;";

	p_getters+="
		public function $varName(): $varType
		{
			return \$this->$varName;
		}";

	p_params+="
		$varType \$$varName,";

	assignValue+="
		\$this->$varName = \$$varName;";

	toArray+="
		'$varName'		=> \$this->$varName(),";

done

start=$((${#p_params} - 2));
p_params=${p_params:1:start}

template='Application/Create/CreateModuleCommand.php';

labels=('module' 'modules' 'uses' 'attributes' 'params' 'assignValue' 'getters');
values=($module $modules "$uses" "$p_attributes" "$p_params" "$assignValue" "$p_getters");
relative="/Application/Create/Create${module}Command.php"; 

build_template $template $labels "$values" "$modulePath/$relative" 

# Updater
template='Application/Update/UpdateModuleCommand.php';
relative="/Application/Update/Update${module}Command.php"; 

build_template $template $labels "$values" "$modulePath/$relative" 

# ModelResponse
template='Application/ModuleResponse.php';

labels=('module' 'modules' 'toArray' 'attributes' 'params' 'assignValue' 'getters');
values=($module $modules "$toArray" "$p_attributes" "$p_params" "$assignValue" "$p_getters");
relative="/Application/${module}Response.php"; 

build_template $template $labels "$values" "$modulePath/$relative" 

#---------------- Write -----------------#

uses='';
assignValue='';
rawParams='';
uses='';

for i in ${!fields[@]};
do

  field=$(echo ${fields[i]} | tr A-Z a-z);
  fieldType=${fieldTypes[$i]}
	fileName="$module$(parse_field_name $field)";
	objName=$(parse_field_name $field);
	varName=$(parse_field_name $field 1);

	if [ $field == id ]
	then
		uses+="
			use Seavices\Backoffice\Shared\Domain\\$module\\$fileName;";
	elif [[ $field =~ .*id$ ]]
	then

		foraingArr=(${field//_/ });

		uses+="
			use Seavices\Backoffice\Shared\Domain\\${foraingArr[0]^}\\$objName;";

		fileName=$objName;
	else
		uses+="
			use Seavices\Backoffice\\$modules\Domain\\$fileName;";

	fi

rawParams+="\$$varName, ";

	if [ $fieldType == 5 ] && [ -z $includedDateTime]
	then
		assignValue+="
			\$$varName = new $fileName(\$command->$varName()->format('Y-m-d H:i:s'));";
	else
		assignValue+="
			\$$varName = new $fileName(\$command->$varName());";
	fi


done

start=$((${#rawParams} - 2));
rawParams=${rawParams:0:start}

template='Application/Create/CreateModuleCommandHandler.php';

labels=('module' 'modules' 'uses' 'assignValue' 'rawParams');
values=($module $modules "$uses" "$assignValue" "$rawParams");
relative="/Application/Create/Create${module}CommandHandler.php"; 

build_template $template $labels "$values" "$modulePath/$relative" 

# Updater
template='Application/Update/UpdateModuleCommandHandler.php';
relative="/Application/Update/Update${module}CommandHandler.php"; 

build_template $template $labels "$values" "$modulePath/$relative" 

#---------------- Write -----------------#

uses='';
assignValue='';
rawParams='';
uses='';
params='';
entitySetters='';

for i in ${!fields[@]};
do

  field=$(echo ${fields[i]} | tr A-Z a-z);
  fieldType=${fieldTypes[$i]}
	fileName="$module$(parse_field_name $field)";
	objName=$(parse_field_name $field);
	varName=$(parse_field_name $field 1);

	if [ $field == id ]
	then
		uses+="
			use Seavices\Backoffice\Shared\Domain\\$module\\$fileName;";
	elif [[ $field =~ .*id$ ]]
	then

		foraingArr=(${field//_/ });

		uses+="
			use Seavices\Backoffice\Shared\Domain\\${foraingArr[0]^}\\$objName;";

		fileName=$objName;
	else
		uses+="
			use Seavices\Backoffice\\$modules\Domain\\$fileName;";

		entitySetters+="
			\$entity->set$objName(\$$varName);";

	fi

	rawParams+="\$$varName, ";

	params+="
		$fileName \$$varName,";

done

start=$((${#params} - 2));
params=${params:1:start}

start=$((${#rawParams} - 2));
rawParams=${rawParams:0:start}

template='Application/Create/ModuleCreator.php';

labels=('module' 'modules' 'uses' 'params' 'rawParams');
values=($module $modules "$uses" "$params" "$rawParams");
relative="/Application/Create/${module}Creator.php"; 

build_template $template $labels "$values" "$modulePath/$relative" 
# Updater
labels=('module' 'modules' 'uses' 'params' 'entitySetters');
values=($module $modules "$uses" "$params" "$entitySetters");
template='Application/Update/ModuleUpdater.php';

relative="/Application/Update/${module}Updater.php"; 

build_template $template $labels "$values" "$modulePath/$relative" 


# --------- Aplication/Find ----------

labels=('module' 'modules');
values=($module $modules);

# --- Query

template='Application/Find/FindModuleQuery.php';
relative="/Application/Find/Find${module}Query.php"; 

build_template $template $labels "$values" "$modulePath/$relative" 

# --- Handler

template='Application/Find/FindModuleQueryHandler.php';
relative="/Application/Find/Find${module}QueryHandler.php"; 

build_template $template $labels "$values" "$modulePath/$relative" 

# --- Finder 

template='Application/Find/ModuleFinder.php';
relative="/Application/Find/${module}Finder.php"; 

build_template $template $labels "$values" "$modulePath/$relative" 

# --------- Aplication/SearchAll ----------

labels=('modules');
values=($modules);

# --- Query

template='Application/SearchAll/SearchAllModulesQuery.php';
relative="/Application/SearchAll/SearchAll${modules}Query.php"; 

build_template $template $labels "$values" "$modulePath/$relative" 

# --- Handler

template='Application/SearchAll/SearchAllModulesQueryHandler.php';
relative="/Application/SearchAll/SearchAll${modules}QueryHandler.php"; 

build_template $template $labels "$values" "$modulePath/$relative" 

# --- Searcher

labels=('module' 'modules');
values=($module $modules);

template='Application/SearchAll/AllModulesSearcher.php';
relative="/Application/SearchAll/All${modules}Searcher.php"; 

build_template $template $labels "$values" "$modulePath/$relative" 

# --------- Aplication/Delete ----------

# --- Command
template='Application/Delete/DeleteModuleCommand.php';
relative="/Application/Delete/Delete${module}Command.php"; 

build_template $template $labels "$values" "$modulePath/$relative" 

# --- Handler
template='Application/Delete/DeleteModuleCommandHandler.php';
relative="/Application/Delete/Delete${module}CommandHandler.php"; 

build_template $template $labels "$values" "$modulePath/$relative" 

# --- Deletor
template='Application/Delete/ModuleDeletor.php';
relative="/Application/Delete/${module}Deletor.php"; 

build_template $template $labels "$values" "$modulePath/$relative" 

# ----------- ModulesResponse ------------

template='Application/ModulesResponse.php';
relative="/Application/${modules}Response.php"; 

build_template $template $labels "$values" "$modulePath/$relative" 

output_success "\nFinished Domain aplication...\n" 
