# --------- Domain ---------
mkdir -p $modulePath/Domain;
mkdir -p $path//Shared/Domain/$module;

attributes='';
setters='';
getters='';
params='';
uses='';
createResponse='';

for i in ${!fields[@]};
do

  field=$(echo ${fields[i]} | tr A-Z a-z);
  fieldType=${fieldTypes[$i]}
	fileName="$module$(parse_field_name $field)";
	objName=$(parse_field_name $field);
	varName=$(parse_field_name $field 1);

	if [ $field == id ]
	then
		relative="/Shared/Domain/$module/${module}Id.php"; 

		template='Domain/ModuleId.php';
		labels=('module');
		values=($module);

		build_template $template $labels $values "$path/$relative" 

uses+="
use Seavices\Backoffice\Shared\Domain\\$module\\$fileName;";

		output_success "Created Backoffice/$relative file" 
	elif [[ $field =~ .*id$ ]]
	then

		foraingArr=(${field//_/ });

uses+="
use Seavices\Backoffice\Shared\Domain\\${foraingArr[0]^}\\$objName;";

		fileName=$objName;
	else
		relative="/Domain/$fileName.php"; 

cat > $modulePath/$relative << EOF
<?php

declare(strict_types=1);

namespace Seavices\Backoffice\\$modules\Domain;

use Seavices\Shared\Domain\ValueObject\\$(get_object_type $fieldType);

final class $fileName extends $(get_object_type $fieldType)
{
}
EOF

		output_success "Created $relative file" 
	fi

attributes+="
	private \$$varName;";

getters+="
	public function $varName(): $fileName
	{
		return \$this->$varName;
	}";

setters+="
	public function set$objName($fileName \$$varName): void
	{
		\$this->$varName = \$$varName;
	}";

params+="
		$fileName \$$varName,";

rawParams+="\$$varName, ";

assignValue+="
		\$this->$varName = \$$varName;";

createResponse+="
			\$${moduleVar}->$varName()->value(),";

done

start=$((${#params} - 2));
params=${params:1:start}

start=$((${#rawParams} - 2));
rawParams=${rawParams:0:start}

relative="/Domain/${module}Read.php"; 

template='Domain/ModuleRead.php';
labels=('module' 'modules' 'uses' 'attributes' 'params' 'assignValue' 'rawParams' 'getters');
values=($module $modules "$uses" "$attributes" "$params" "$assignValue" "$rawParams" "$getters");

build_template $template $labels "$values" "$modulePath/$relative"; 

#---------------- Write -----------------#

relative="/Domain/${module}Write.php"; 

template='Domain/ModuleWrite.php';
labels=('module' 'modules' 'uses' 'attributes' 'params' 'assignValue' 'rawParams' 'getters' 'setters');
values=($module $modules "$uses" "$attributes" "$params" "$assignValue" "$rawParams" "$getters" "$setters");

build_template $template $labels "$values" "$modulePath/$relative"; 

#---------------- DomainEvent -----------------#

relative="/Domain/${module}CreatedDomainEvent.php"; 
template='Domain/ModuleCreatedDomainEvent.php';

lowModules=${module~};
labels=('module' 'modules' 'lowModules' 'attributes' 'rawParams' 'assignValue');
values=($module $modules "$lowModules" "$attributes" "$rawParams" "$assignValue");

build_template $template $labels "$values" "$modulePath/$relative"; 

#-------------- Repository Read ---------------#

relative="/Domain/${module}RepositoryRead.php"; 
cat > $modulePath/$relative << EOF
<?php

declare(strict_types=1);

namespace Seavices\Backoffice\\$modules\Domain;

use Seavices\Backoffice\Shared\Domain\\${module}\\${module}Id;
use Seavices\Shared\Domain\Criteria\Criteria;

interface ${module}RepositoryRead
{
	public function matching(Criteria \$criteria):array;

	public function searchAll(): array;
	
	public function find(${module}Id \$id): ?${module}Read;

}

EOF

output_success "Created $relative file" 

#-------------- Repository Write ---------------#

relative="/Domain/${module}RepositoryWrite.php"; 
cat > $modulePath/$relative << EOF
<?php

declare(strict_types=1);

namespace Seavices\Backoffice\\$modules\Domain;

use Seavices\Backoffice\\$modules\Domain\\${module}Write;
use Seavices\Backoffice\Shared\Domain\\${module}\\${module}Id;

interface ${module}RepositoryWrite
{
    public function save(${module}Write \$entity): void;

    public function find(${module}Id \$id): ?${module}Write;

    public function delete(${module}Id \$id): void;
}

EOF

output_success "Created $relative file" 

#-------------- Create Response ---------------#

start=$((${#createResponse} - 1));
createResponse=${createResponse:0:start}

relative="/Domain/${module}CreateResponse.php"; 
cat > $modulePath/$relative << EOF
<?php

declare(strict_types=1);

namespace Seavices\Backoffice\\$modules\Domain;

use Seavices\Backoffice\\$modules\Application\\${module}Response;

final class ${module}CreateResponse
{
	public static function create(${module}Read \$${moduleVar}): ${module}Response
	{
		return new ${module}Response(
$createResponse
		);
	}
}
EOF

output_success "Created $relative file" 

#-------------- Create Response ---------------#

relative="/Domain/${module}NotExist.php"; 
cat > $modulePath/$relative << EOF
<?php

declare(strict_types=1);

namespace Seavices\Backoffice\\$modules\Domain;

use RuntimeException;

final class ${module}NotExist extends RuntimeException
{
	public function __construct()
	{
		parent::__construct('${module} not exist');
	}
}
EOF

output_success "Created $relative file" 

#-------------- Create Response ---------------#

relative="/Domain/${module}AlreadyExists.php"; 
cat > $modulePath/$relative << EOF
<?php

declare(strict_types=1);

namespace Seavices\Backoffice\\$modules\Domain;

use RuntimeException;

final class ${module}AlreadyExists extends RuntimeException
{
	public function __construct()
	{
		parent::__construct('${module} already exist');
	}
}
EOF

output_success "Created $relative file" 

output_success "\nFinished Domain created...\n" 
