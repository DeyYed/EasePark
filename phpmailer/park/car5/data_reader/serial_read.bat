@echo off
mode COM3: BAUD=9600 PARITY=N data=8 stop=1 xon=off
type COM3
