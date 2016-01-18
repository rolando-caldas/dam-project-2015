#!/usr/bin/env python
# -*- coding: UTF-8 -*-
#
# Autor:     Jose Ramon Vilas
#            joservilas@gmail.com
#            http://joservilas.blogspot.com/
 
class nifCif:
    def __init__(self,codigoNifCif):
        self.lstClavesCif = ['A','B','C','D','E','F','G','H','K','L','M','N','P','Q','S']
        self.lstClavesCifFinLetra = ['K', 'P', 'Q', 'S']
        self.lstClavesCifFinNumero = ['A', 'B', 'E', 'H']
        self.dicEquivalenciasCif = {1:'A', 2:'B', 3:'C', 4:'D', 5:'E', 6:'F', 7:'G', 8:'H', 9:'I', 10:'J'}
        self.NIF='TRWAGMYFPDXBNJZSQVHLCKE'
        self.valido = False
        self.codigoNifCif=codigoNifCif.upper()
    def validar(self):
        if len(self.codigoNifCif) == 9:
            try:
                if self.codigoNifCif[0] in self.lstClavesCif:
                    # Es un Cif
                    numCif = self.codigoNifCif[1:-1]
                    sumPares = int(numCif[1]) + int(numCif[3]) + int(numCif[5])
                    lstImpares = []
                    lstImpares.append(int(numCif[0]) * 2) 
                    lstImpares.append(int(numCif[2]) * 2) 
                    lstImpares.append(int(numCif[4]) * 2) 
                    lstImpares.append(int(numCif[6]) * 2)
                    sumaImpares = 0
                    for i in lstImpares:
                        if i < 10:
                            sumaImpares += i
                        else:
                            sumaImpares += int(str(i[0])) + int(str(i[1]))
                    d = 10 - (int(str(sumPares[-1:])) + int(str(sumaImpares[-1:])))
                    letraCif = self.dicEquivalenciasCif[d]
                    if self.codigoNifCif[0] in self.lstClavesCifFinLetra and self.codigoNifCif[-1:] == letraCif:
                        self.valido = True
                    elif self.codigoNifCif[0] in self.lstClavesCifFinNumero and self.codigoNifCif[-1:] == str(d):
                        self.valido = True
                    elif self.codigoNifCif[-1:] == str(d) or self.codigoNifCif[-1:] == letraCif:
                        self.valido = True
                    else:
                        self.valido = False
 
                elif self.codigoNifCif[0] == 'X':
                    # Es un Nif de extranjero
                    numDni = int(self.codigoNifCif[1:-1])
                    if self.NIF[numDni%23] == self.codigoNifCif[-1:]:
                        self.valido = True
                    else:
                        self.valido = False
                else:
                    # Es un Nif
                    numDni = int(self.codigoNifCif[:-1])
                    print(self.codigoNifCif)
                    print(numDni)
                    print(self.NIF[numDni%23])
                    print(self.codigoNifCif[-1:])
                    if self.NIF[numDni%23] == self.codigoNifCif[-1:]:
                        self.valido = True
                    else:
                        self.valido = False
 
            except:
                self.valido = False
        else:
            self.valido = False
 
        return self.valido
    
    def validar_nif(self):
        
        self.valido = False
        if len(self.codigoNifCif) == 9:
            try:
                # Es un Nif
                numDni = int(self.codigoNifCif[:-1])
                if self.NIF[numDni%23] == self.codigoNifCif[-1:]:
                    self.valido = True
 
            except:
                self.valido = False
 
        return self.valido