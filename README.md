# shellboy

ShellBoy is a useful web shell finder. It simply knows the signatures of active or inactive webshells on the market and looks for these signatures in files on your server. 

## Latest Release

Please follow github release pages for binaries

* [github.com/c1982/shellboy/releases/latest](https://github.com/c1982/shellboy/releases/latest)

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


# Yara Files Sources
* https://raw.githubusercontent.com/Neo23x0/signature-base/50f14d7d1def5ee1032158af658a5c0b82fe50c9/yara/thor-webshells.yar
* https://github.com/DarkenCode/yara-rules/blob/master/malware/Webshell-shell.yar

# Data Sources
* https://github.com/tennc/webshell.git
* https://github.com/ysrc/webshell-sample.git
* https://github.com/xl7dev/WebShell.git
* https://github.com/JohnTroony/php-webshells/tree/master/Collection
* https://github.com/tanjiti/webshellSample.git
* https://github.com/BlackArch/webshells
* https://github.com/tutorial0/WebShell