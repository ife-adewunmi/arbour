# Changelog

All notable changes to `Arbour SAP Package` will be documented in this file.

## v1.0.0 - 2024-07-13

- refactor: change package namespace
- fix loading Localizations
- refactor: remove unused old generator
- feat: add ContainerGenerator command
- feat: add --resource option in ControllerGenerator command
- feat: add --requests parameter in ControllerGenerator
- feat: add FilamentResourceGenerator command
- feat: add MigrationGenerator command
- feat: add FactoryGenerator command
- feat: add ApiRequestGenerator command
- feat: add ProviderGenerator command
- feat: add ApiResourceGenerator command
- feat: add ApiRoutesGenerator command
- feat: add ControllerApiGenerator command
- feat: add ModelGenerator command
- fix: loadViews with prefix "container@{containerName}::{view.name}"
- fix: run-tests.yml
- fix: phpstan errors
- require laravel 10
- rename stub files, add prepend Abstract to name
- fix: registerMiddlewareGroups function
- fix: autoload service providers
- fix: deploy branch name
- add: /Database folder beside with /Data
- fix: load localizations in register() method, instead boot()
- add: PathsLoader trait
- update: CHANGELOG.md
- create: PathLoader trait
- format: code by pint
- add: universal load path method
- load: StemProvider if exists
- add: loaders
- add: abstracts
- autoload all Branches
