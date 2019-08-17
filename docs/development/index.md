# Development of Slacky

## Travis

For Travis an environment variable file must be filled with all necessary defines. 
If a variable is added or changed in .env.trav the file needs to be re-encrypted.
This can be done by running the following command: 
``travis encrypt-file .env.trav --add``
