#!/bin/bash

set -e

# --------- Controller ----------

appPath='../apps/backoffice/backend';

mkdir -p $appPath/src/Controller/$modules;

lowerModule=${module~}
lowerModules=${modules~}
labels=('module' 'modules' 'lowerModule' 'lowerModules');
values=($module $modules $lowerModule $lowerModules);

# -------------
template='Controller/ModuleCreatePostApiController.php';
relative="src/Controller/$modules/${module}CreatePostApiController.php"; 

build_template $template $labels "$values" "$appPath/$relative" 

# -------------

template='Controller/ModuleDeleteDeleteApiController.php';
relative="src/Controller/$modules/${module}DeleteDeleteApiController.php"; 

build_template $template $labels "$values" "$appPath/$relative" 

# -------------
template='Controller/ModuleFindGetApiController.php';
relative="src/Controller/$modules/${module}FindGetApiController.php"; 

build_template $template $labels "$values" "$appPath/$relative" 

# -------------
template='Controller/ModuleSearchAllGetApiController.php';
relative="src/Controller/$modules/${module}SearchAllGetApiController.php"; 

build_template $template $labels "$values" "$appPath/$relative" 

# -------------
template='Controller/ModuleUpdatePutApiController.php';
relative="src/Controller/$modules/${module}UpdatePutApiController.php"; 

build_template $template $labels "$values" "$appPath/$relative" 

# -------------
template='Controller/routes.yaml';
relative="config/routes/$lowerModules.yaml"; 

build_template $template $labels "$values" "$appPath/$relative" 
