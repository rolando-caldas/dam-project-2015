from django.db import models
from django.core.exceptions import ValidationError
from app.cif import nifCif
from django.utils.timezone import now

def validate_cif(cif):
    cifClass = nifCif(cif)
    if cifClass.validar() == False:
        raise ValidationError("NIF / CIF not valid")

def validate_nif(nif):
    cifClass = nifCif(nif)
    if cifClass.validar_nif() == False:
        raise ValidationError("NIF not valid")

# Create your models here.
class Cliente(models.Model):    
    
    cif = models.CharField(max_length=100, null=False, blank=False, unique=True, validators=[validate_cif]);
    denominacion_social = models.CharField(max_length=255, blank=True, default='');
    direccion = models.TextField()
    telefono = models.IntegerField()
    
    class Meta:
        ordering = ('cif',)
        
class Transportista(models.Model):
    
    apellidos = models.CharField(max_length=255, null=False, blank=False)
    nif = models.CharField(max_length=100, null=False, blank=False, unique=True, validators=[validate_nif]);
    nombre = models.CharField(max_length=100, null=False, blank=False)
    telefono = models.IntegerField()
    owner = models.ForeignKey('auth.User', blank=True, null=True, on_delete=models.SET_NULL, related_name='transportista_user')    
    
    class Meta:
        ordering = ('nif',)
            
class Envio(models.Model):
    
    cliente = models.ForeignKey(Cliente, blank=True, null=True, on_delete=models.SET_NULL, related_name="envio_cliente")
    destinatario = models.CharField(max_length=255, null=False, blank=False)
    direccion = models.TextField(null=False, blank=False)
    fecha_creacion = models.DateTimeField(default=now, null=False, blank=False)
    entregado = models.BooleanField(default=False)
    transportista = models.ForeignKey(Transportista, blank=True, null=True, on_delete=models.SET_NULL, related_name="envio_transportista")
    
    class Meta:
        ordering = ('fecha_creacion',)
        
        
class Entrega(models.Model):

    envio = models.ForeignKey(Envio, blank=True, null=True, on_delete=models.SET_NULL, related_name="entrega_envio")
    fecha_entrega = models.DateTimeField(default=now, null=False, blank=False)
    firma = models.TextField(null=True, blank=True)
    observaciones = models.TextField(null=True, blank=True)
    transportista = models.ForeignKey(Transportista, blank=True, null=True, on_delete=models.SET_NULL, related_name="entrega_transportista")
