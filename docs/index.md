Hello there,
ShellBoy is a useful web shell finder. It simply knows the signatures of active or inactive webshells on the market and looks for these signatures in files on your server. 


## Latest Release

Please follow github release pages

* https://github.com/c1982/shellboy/releases/tag/v0.0.1-beta

## Usage

ShellBoy is designed as a command line application. You can run it directly by giving the main directory you want to be scanned. 

> ./shellboy --directory=/usr/local/vhosts

## Parameters

|args| desc |
|---|---|
| directory  | Root directory for scan |
| score | Minimum similarity score |
| minbytes | Minimum file size (byte). Default 4kb |
| maxbytes | Maximum file size (byte). Default 1Mb |
| excludes | Excluded file extensions. Empty is disabled |
| includes | Included file extensions. Default empty |
| help | Display this help message |
| v | Verbose mode |

## Examples

Scan only PHP files.

>shellboy --directory=/usr/local/vhosts --includes=php,phps

Exclude images files sanning

>shellboy --directory=/usr/local/vhosts --excludes=jpeg,png,gif

Change minimum similarity score. This value increases skepticism 

>shellboy --directory=/usr/local/vhosts --score=75


