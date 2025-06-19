# Drupal Assessment

This repo was added to demonstrate some of the Drupal capabilities.

## Setup

To view **locally**, clone the repo then execute

```
ddev start
```

The site should be accessible at http://drupal-assessment.ddev.site

Also, an online **demo** version can be seen at http://drupal-assessment.ericmaster.ninja

## Usage

1. **Controller 1 Implementation**
   - Access http://drupal-assessment.ddev.site/hello-velir-1/{your-name}
   - You should see "Hello, my name is {your-name}."
2. **Controller 2 Implementation**
   - Access http://drupal-assessment.ddev.site/hello-velir-2/{your-name}
   - You should get the following JSON output
```javascript
{
  message: "Hello, my name is {your-name}.",
  status: "success"
}
```
3. **Config Entity**
   - As an admin, go to http://drupal-assessment.ddev.site/admin/structure/person which should list all person config entities if any
   - Click on **+ Add person-=** or go to http://drupal-assessment.ddev.site/admin/structure/person/add to add a new Person config entity
   - Fill in "First Name" and "Last Name" fields and submit
   - You should see the new config entity in the persons listing page
   - Other CRUD operations are available: *Edit* and *Delete*
4. **Field Formatter**
   - As an admin, go to http://drupal-assessment.ddev.site/node/add/article to add a new article
   - Fill the required **title** field and the subtitle field and submit
   - You should see the **subtitle** text in uppercase
5. **Controller 3 Implementation**
   - As an anonymous user visit http://drupal-assessment.ddev.site/hello-velir-3/{your-name}
   - You should get a 403 response with an **Access Denied** message
   - As an administrator user visit http://drupal-assessment.ddev.site/hello-velir-3/{your-name}
   - You should see "Hello, my name is {your-name}."
6. **Block plugin**
   - As an anonymous user, visit any page (e.g. http://drupal-assessment.ddev.site/)
   - You should see a **Log In** button in the *header* region (top left in olivero theme)
   - As an admin user, visit any page (e.g. http://drupal-assessment.ddev.site/)
   - You should see the text **Welcome, {username}!** in the *header* region (top left in olivero theme)
7. **ContentEntityNormalizer**
   - Make sure a node has been created (e.g. http://drupal-assessment.ddev.site/node/add/article)
   - Go to http://drupal-assessment.ddev.site/api/nodes?_format=json
   - You should get a node JSON output containing the entry `velir: "212"`
8. **Custom Data Entity** vs **Node entity**
   - A **Node entity** is more suitable for content that is meant to be managed by content editors (potentially subject to an editorial workflow and revisions) and be output in pages to the users for content consumption.
   - A **Custom data entity** is more suitable to hold data related to a business logic or internal application records, but needs to leverage Drupal content entities APIs like access control, storage API, etc.
   - Using a **Node entity** when it should not may lead to the following downsides
     -  Overkill features like revisions, status, etc may add unnecesary overhead
     -  It can be mixed in content listings a may need to be filtered out in different views to avoid confusion
     -  May be tricky to customize access control when it is subject to content permissions

## Testing

* Execute `ddev ssh` to enter the container or `ddev exec` followed by the command below
* Then run the following command to execute the tests
```bash
SIMPLETEST_DB='mysql://db:db@db/db' SIMPLETEST_BASE_URL=http://drupal-assessment.ddev.site vendor/bin/phpunit --configuration web/core/phpunit.xml.dist web/modules/custom/custom_module
```
