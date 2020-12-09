# file-upload-form
A simple Php, JS, HTML upload form example

# Database Configuration

There is a database save at the end of the upload, tested in MySQL. Here is information on the table structure that must be set up beforehand in order for this demo to work:

 - Database configuration be found in *config.php*.
 - Database should contain a table called `files`
 - `files` table should contain fields called `file_path` and `meta_title`. You might wish to have an auto-incrementing primary key, and to add or remove any other fields as desired.

 ## Example Table

 Please note that the code does not have any constraints for length. That is something you should add based on your specific needs. This is not a complete, production example — but rather a starting point to build from.

 | id (pk) | file_path              | meta_title |
 |---------|------------------------|------------|
 | 00001   |example.com/file-1.jpg  | First File |