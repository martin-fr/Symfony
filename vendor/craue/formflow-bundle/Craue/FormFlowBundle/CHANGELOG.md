# Changelog

## 2.1.2 (2013-09-26)

- #90: fixed the step list to render the last step already been visited (but not submitted) as a link

## 2.1.1 (2013-09-24)

- ensure that `skip` callables always return a boolean value
- #87: the step parameter used in links to specific steps is not limited to be a query parameter anymore, e.g. can be a route parameter

## 2.1.0 (2013-08-27)

- #75: the hidden step field is automatically added to the form (follow `UPGRADE-2.1.md` to upgrade)

## 2.0.1 (2013-07-12)

- fixed steps being incorrectly marked as skipped when resetting the flow

## 2.0.0 (2013-05-27)

- BC breaks (follow `UPGRADE-2.0.md` to upgrade):
  - #46: reworked the way steps are defined
  - adjustments in handling the request for Symfony 2.3 compatibility
- #52: added `GetStepsEvent`
- added `PostBindFlowEvent`

## 1.1.3 (2013-05-23)

- #48: added method `getStorage`
- made the dependency on an event dispatcher optional

## 1.1.2 (2013-04-17)

- always dispatch `PreBindEvent` when `bind` is called (to match expected behavior)
- #45: added Brazilian Portuguese translation

## 1.1.1 (2013-04-14)

- avoid skipping all steps by tampering with the hidden step field
- added some basic tests

## 1.1.0 (2013-02-28)

- adjustments to changes in the Form component for Symfony 2.1.*
- adjustments to changes in the HttpFoundation component for Symfony 2.1.*
- #21: added `StorageInterface`
- #23: added route parameters to links generated for dynamic step navigation
- preserve given `validation_groups` option
- added the flow instance as a property in events
- throw an exception if the number of steps doesn't match the number of step descriptions

## 1.0.0 (2012-03-07)

- first stable release for Symfony 2.0.*

## 2011-08-02

- initial commit
