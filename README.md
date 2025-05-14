#Task Management API
A simple and secure Laravel-based RESTful API for managing tasks. This system allows users to create, update, retrieve, and delete tasks, with built-in authentication and status control.

📊 Features Analysis
🔐 Authentication
Uses Laravel Sanctum for token-based authentication.

Only authenticated users can create, view, or modify their tasks.

📂 Task Management
CRUD operations (Create, Read, Update, Delete) for tasks.

Tasks are linked to individual users.

Only the owner of a task can modify or delete it.

📈 Task Status
Tasks are associated with a status (e.g., pending, in progress, done).

Validation ensures non-admin users can only use allowed status names.

Admin users can freely manage status entries.
