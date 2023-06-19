@echo off
cd ".\"
start "" php -S localhost:3000
ping 127.0.0.1 -n 5 > nul
start chrome http://localhost:3000
exit
