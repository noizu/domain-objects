# Domain Objects

Noizu Domain Objects is a collection of essential components and tools designed to streamline development with Doctrine ORM. It offers various functionalities, including domain object management, moderated strings, email queuing, user management, file uploading, and more. These components aim to provide a solid foundation for building robust and scalable PHP applications.


## Features

### Doctrine ORM Integration

Noizu Core leverages the power of Doctrine ORM, a popular object-relational mapper (ORM) for PHP. By utilizing Doctrine, the project benefits from:

* **Simplified Database Interactions:**  Doctrine allows developers to work with database records as objects, making interactions more intuitive and efficient.
* **Entity Relationships Management:**  Doctrine simplifies the management of relationships between entities, ensuring data integrity and consistency. 
* **Database Abstraction:**  The project becomes less dependent on specific database systems, allowing for easier migration and adaptation. 

**Example:**

```php
// Retrieve a user entity using Doctrine Entity Manager
$entityManager = $container['EntityManager'];
$user = $entityManager->find('NoizuLabs\Core\Doctrine\Entity\Users', 1);
```

### Domain Objects

Noizu Core implements the Domain Object pattern, which encapsulates business logic and data within objects. This approach provides several advantages:

* **Separation of Concerns:** Domain objects clearly separate business logic from data access and presentation logic, promoting maintainability and code reusability.
* **Data Integrity:** Domain objects ensure data consistency and enforce business rules, preventing invalid data from entering the system.
* **Testability:** Domain objects can be easily tested in isolation, leading to improved code quality and reliability.

**Example:**

```php
// Using the User domain object to manage user data
$user = new NoizuLabs\Core\DomainObject\User();
$user->load(1); // Load user with ID 1
$user->setEmail('new_email@example.com');
$user->save(); // Persist changes to the database
```

### Moderated Strings

The project includes a robust system for managing moderated strings. This feature is particularly useful for situations where text content needs to be reviewed and approved before being published. Key functionalities include:

* **Change Logs:** Tracks changes made to strings, including timestamps, authors, and actions.
* **Pending and Approved Texts:** Allows for strings to be in a pending or approved state, ensuring only reviewed content goes live.
* **Revision History:** Provides access to the history of changes made to a string.

**Example:**

```php
// Creating a new moderated string
$ms = $container['Do_Repository_ModeratedStrings'];
$moderatedString = $ms->createModeratedString("This is a new string", 1, $user); 

// Editing a moderated string
$moderatedString->edit("This is an updated string", array('author' => $adminUser));
```

### Email Template Queue

Noizu Core provides a sophisticated email queuing system that utilizes templates for creating and sending emails. Key features include:

* **Template Management:** Define and manage email templates with friendly names, subjects, and body content.
* **Data Binding:** Bind dynamic data to email templates using placeholders and replacement tags.
* **Queue Processing:** Queue emails for later delivery and process them asynchronously.
* **Error Handling:** Handles errors during email processing and provides detailed logs.

**Example:**

```php
// Queueing an email using a template
$emailQueue = $container['Do_Repository_TemplatedEmailQueue'];
$emailQueue->queueEmail($templateId, $user, $emailData);

// Processing the email queue
$queuedEmail = $emailQueue->getReadyToSend(1);
$queuedEmail->send();
```

### User Management

The project includes fundamental user management functionalities, such as:

* **User Creation:** Allows for creating new user accounts with basic information like username, password, and email. 
* **User Authentication:** Supports user login and authentication.
* **User Data Management:** Enables managing user data and profiles.

**Example:**

```php
// Creating a new user
$userRepository = $container['Do_Repository_Users'];
$user = $userRepository->createUser($userData); 
```

### File Uploading

Noizu Core provides helper functions for importing and uploading files. These functions simplify the process of:

* **File Type Validation:** Ensures uploaded files have the correct extensions.
* **File Storage:** Handles storing uploaded files in designated directories.
* **File Management:** Provides functionalities for managing uploaded files.

**Example:**

```php
// Uploading a file
$domainObject->uploadFile($subDir, $tmpPath, $originalFileName, $allowedExtensions);
```

### Error and Warning Logging

The project implements a comprehensive logging system for capturing errors, warnings, and debug messages. This system helps with:

* **Error Tracking:**  Identifies and tracks errors during application execution.
* **Debugging:** Provides valuable information for debugging and troubleshooting issues. 
* **Application Monitoring:** Allows for monitoring the health and performance of the application. 

**Example:**

```php
// Logging an error message 
$domainObject->LogError("400:002", "Invalid Field - $field must be set");
```

### Rights Management (In Progress)

The project appears to have a framework for rights management and access control, but it's noted as "in progress". Further development is likely needed to provide full-fledged rights management capabilities. 

### Convenience Methods 

Noizu Core includes several convenience methods to simplify common tasks:

* **Converting Entities to Arrays:** Allows for easy conversion of Doctrine entities to arrays for further processing or data transfer.
* **Retrieving All Entities with Pagination:** Provides a method to retrieve all entities of a specific type with pagination support. 
* **Generating Unique Identifiers:** Offers a method for generating unique GUIDs.

**Example:**

```php
// Retrieving all users with pagination
$users = $userDomainObject->getAllEntitiesArray(1, 20);
``` 

## Installation and Setup

### Prerequisites

Before installing Noizu Core, ensure you have the following prerequisites:

* **PHP 5.3 or higher:** The project requires a compatible PHP version.
* **Composer:** A dependency management tool for PHP is needed for installation. 
* **Database System:**  A supported database system, like MySQL, is required. 
* **Doctrine ORM:** Install Doctrine ORM using Composer.

### Installation via Composer 

1. Add the Noizu Core package to your project's `composer.json` file:

```json
"require": {
    "noizu-labs/core": "dev-master"
}
```

2. Run the following command to install the package and its dependencies:

```bash
composer install
```

### Setup

1. **Configure Database Connection:** Create a `db_settings.php` file with your database credentials. You can use the provided `db_settings.php.sample` as a template. 
2. **Bootstrap Doctrine:**  Include the Doctrine bootstrap file in your application's entry point:

```php
require_once(__DIR__ . '/vendor/noizu-labs/core/src/NoizuLabs/Core/Doctrine/bootstrap.php');
```

3. **Dependency Injection Configuration:** Configure the Pimple container with necessary services and parameters as needed for your application.

4. **Additional Settings:** Set any additional configuration options, such as `Settings.UploadFolder` for file uploads, and customize the project according to your specific requirements.


## Usage Examples

### Moderated Strings

**Creating a Moderated String:**

```php
// Instantiate the ModeratedStrings repository
$moderatedStringsRepository = $container['Do_Repository_ModeratedStrings'];

// Create a new moderated string with initial text and type
$moderatedString = $moderatedStringsRepository->createModeratedString(
    "Initial string content", 
    1, // String type ID
    $user // Author of the string
);

// Save the moderated string
$moderatedString->save();
```

**Editing a Moderated String:**

```php
// Load the moderated string you want to edit
$moderatedString->load($stringId);

// Edit the string content
$moderatedString->edit("Updated string content", array('author' => $adminUser)); 
```

### Email Template Queue

**Queueing an Email:**

```php
// Instantiate the TemplatedEmailQueue repository
$emailQueueRepository = $container['Do_Repository_TemplatedEmailQueue']; 

// Define email data
$emailData = array(
    'userName' => $user->getUserName(),
    'verificationLink' => $verificationLink
);

// Queue the email using a specific template and user
$queuedEmail = $emailQueueRepository->queueEmail(
    $templateId, // Email template ID
    $user, 
    $emailData
);
```

**Processing the Email Queue:**

```php
// Retrieve emails ready to be sent
$queuedEmails = $emailQueueRepository->getReadyToSend(10); // Get up to 10 emails

// Send each queued email
foreach ($queuedEmails as $queuedEmail) {
    $queuedEmail->send(); 
} 
``` 

