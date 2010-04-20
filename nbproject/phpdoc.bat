@echo on
cd C:\Users\cdmckay\XAMPP\php\PEAR\data\PhpDocumentor
C:/Users/cdmckay/XAMPP/php/php.exe C:/Users/cdmckay/XAMPP/php/PEAR/PhpDocumentor/phpDocumentor/phpdoc.inc -d %2 -t %3
"%ProgramFiles(x86)%\Mozilla Firefox\firefox.exe" file://%3/index.html