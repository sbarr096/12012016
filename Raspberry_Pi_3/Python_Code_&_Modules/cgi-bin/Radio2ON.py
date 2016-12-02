import sys
import time
########################Modules Path Information################################

########################Modules Path Information################################
from lib_nrf24 import NRF24
import RPi.GPIO as GPIO
import spidev
import array

i=0
while (i<5):
    


    str = "radio2"
      
    GPIO.setmode (GPIO.BCM)
    GPIO.setwarnings(False)
    str = NRF24 (GPIO, spidev.SpiDev())

    start = time.time()
    #Send and receive addresses
    pipes = [[0xE8, 0xE8, 0xF0, 0xF0, 0XE1]]

    #begin radio and pass CSN to gpio (8/ce0) and CE to gpio 17
    str.begin(0,17)

    #Max bytes 32
    str.setPayloadSize(32)
    str.setChannel(0x76)
    str.setDataRate(NRF24.BR_1MBPS)
    str.setPALevel(NRF24.PA_MIN)
    str.setAutoAck(False)
    str.enableDynamicPayloads()
    str.enableAckPayload()
    str.openWritingPipe(pipes[0])
    
    time.sleep(1/5)    
    str.openReadingPipe(1, [0xF0, 0xF0, 0xF0, 0xF0, 0xE1])
    time.sleep(1/5)

    msg = list ("radio2ON")
    while len(msg) < 32:
        msg.append(0)

    
    str.write(msg)
    print("sent msg: {}".format(msg))
    #The Pi's NRF24 is not listening and waiting on the arduino to reply
    #str.startListening()

    time.sleep(1/10)
    i=i+1



