from django.contrib.auth.models import User
from rest_framework import serializers
from app.models import Cliente
from app.models import Entrega
from app.models import Envio
from app.models import Transportista

class ClienteSerializer(serializers.ModelSerializer):
    
    envio_cliente = serializers.PrimaryKeyRelatedField(many=True, read_only=True)
    
    class Meta:
        model = Cliente
        fields = ('id', 'cif', 'telefono', 'denominacion_social', 'direccion', 'envio_cliente')

class EntregaSerializer(serializers.ModelSerializer):

    class Meta:
        model = Entrega
        fields = ('id', 'envio', 'fecha_entrega', 'firma', 'observaciones', 'transportista')

class EnvioSerializer(serializers.ModelSerializer):
    
    entrega_envio = serializers.PrimaryKeyRelatedField(many=True, read_only=True)
    
    class Meta:
        model = Envio 
        fields = ('id', 'destinatario', 'direccion', 'fecha_creacion', 'entregado', 'transportista', 'cliente', 'entrega_envio')


class TransportistaSerializer(serializers.ModelSerializer):

    envio_transportista = serializers.PrimaryKeyRelatedField(many=True, read_only=True)
    owner = serializers.ReadOnlyField(source='owner.username')
    
    class Meta:
        model = Transportista
        fields = ('id', 'apellidos', 'nif', 'nombre', 'telefono', 'envio_transportista', 'owner')


class UserSerializer(serializers.ModelSerializer):
    
    transportista_user = serializers.PrimaryKeyRelatedField(many=True, queryset=Transportista.objects.all())

    class Meta:
        model = User
        fields = ('id', 'username', 'transportista_user')        
        
