# Basic crm
This project is a test a had to do for applying to a job

## Small project in Laravel of a basic mini CRM to manage companies and their employees
### Specifications of the project
- Use hcps://adminlte.io/ as a framework for the applicaXon
- Basic Laravel Auth: ability to log in as administrator
- Use database seeds to create first user with email admin@admin.com and password
“password”
- CRUD funcXonality (Create / Read / Update / Delete) for two menu items: Companies and
Employees.
- Companies DB table consists of these fields: Name (required), email, logo (minimum
-%%×-%%), website
- Employees DB table consists of these fields: First name (required), last name (required),
Company (foreign key to Companies), email, phone
- Use database migraXons to create those schemas above
- Store companies’ logos in storage/app/public folder and make them accessible from public
- Use basic Laravel resource controllers with default methods – index, create, store etc.
- Use Laravel’s validaXon funcXon, using Request classes
- Use Laravel’s paginaXon for showing Companies/Employees list, -% entries per page
- Use Laravel make:auth as default Bootstrap-based design theme, but remove ability to
register
