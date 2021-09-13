# sneltest
a php-based website, built to make self-test passports with a 3-day validity, designed for communities and semi-secure

this site makes use of the phpqrcode package (http://phpqrcode.sourceforge.net/)

1. take a selfie
2. take a picture of your selftest
3. enter a security code
  --> this security code can be self-made.
  --> this security code can also be set by the project owner, to control at which point in time self-test reports need to be made
4. create your passport
5. Store as image

Your passport expires after 3 days. It can be scanned by any QR scanner.
If a security code was used, the content of the passport can only be seen after entering this code.

No health information is stored on any server, all data is encrypted and in your QR code only.
