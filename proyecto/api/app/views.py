from django.contrib.auth.models import User
from rest_framework import status, generics, permissions
from rest_framework.decorators import api_view
from rest_framework.response import Response
from app.models import Cliente, Entrega, Envio, Transportista
from app.permissions import IsOwnerOrAdmin
from app.serializers import ClienteSerializer, EntregaSerializer, EnvioSerializer, TransportistaSerializer, UserSerializer

class ClienteDetail(generics.RetrieveUpdateDestroyAPIView):
    queryset = Cliente.objects.all()
    serializer_class = ClienteSerializer
    permission_classes = (permissions.IsAuthenticated,IsOwnerOrAdmin,)
    
class ClienteList(generics.ListCreateAPIView):
    queryset = Cliente.objects.all()
    serializer_class = ClienteSerializer
    permission_classes = (permissions.IsAuthenticated,IsOwnerOrAdmin,)

class EntregaDetail(generics.RetrieveUpdateDestroyAPIView):
    queryset = Entrega.objects.all()
    serializer_class = EntregaSerializer
    permission_classes = (permissions.IsAuthenticated,IsOwnerOrAdmin,)
    
class EntregaDetailEnvio(generics.ListAPIView):
    serializer_class = EntregaSerializer
    permission_classes = (permissions.IsAuthenticated,IsOwnerOrAdmin,)

    def get_queryset(self) :
        return Entrega.objects.filter(envio=self.kwargs['envio'])

class EntregaList(generics.ListCreateAPIView):
    queryset = Entrega.objects.all()
    serializer_class = EntregaSerializer
    permission_classes = (permissions.IsAuthenticated,IsOwnerOrAdmin,)

class EnvioDetail(generics.RetrieveUpdateDestroyAPIView):
    queryset = Envio.objects.all()
    serializer_class = EnvioSerializer
    permission_classes = (permissions.IsAuthenticated,IsOwnerOrAdmin,)

class EnvioDetailCliente(generics.ListAPIView):
    serializer_class = EnvioSerializer
    permission_classes = (permissions.IsAuthenticated,IsOwnerOrAdmin,)

    def get_queryset(self) :
        return Envio.objects.filter(cliente=self.kwargs['cliente'])
    
class EnvioDetailTransportista(generics.ListAPIView):
    serializer_class = EnvioSerializer
    permission_classes = (permissions.IsAuthenticated,IsOwnerOrAdmin,)

    def get_queryset(self) :
        return Envio.objects.filter(transportista=self.kwargs['transportista'])

class EnvioDetailTransportistaEntregado(generics.ListAPIView):
    serializer_class = EnvioSerializer
    permission_classes = (permissions.IsAuthenticated,IsOwnerOrAdmin,)

    def get_queryset(self) :
        return Envio.objects.filter(transportista=self.kwargs['transportista'], entregado=True)

class EnvioDetailTransportistaPendiente(generics.ListAPIView):
    serializer_class = EnvioSerializer
    permission_classes = (permissions.IsAuthenticated,IsOwnerOrAdmin,)

    def get_queryset(self) :
        return Envio.objects.filter(transportista=self.kwargs['transportista'], entregado=False)    
    
class EnvioList(generics.ListCreateAPIView):
    queryset = Envio.objects.all()
    serializer_class = EnvioSerializer
    permission_classes = (permissions.IsAuthenticated,IsOwnerOrAdmin,)

class TransportistaDetail(generics.RetrieveUpdateDestroyAPIView):
    queryset = Transportista.objects.all()
    serializer_class = TransportistaSerializer
    permission_classes = (permissions.IsAuthenticated,IsOwnerOrAdmin,)
    
class TransportistaList(generics.ListCreateAPIView):
    queryset = Transportista.objects.all()
    serializer_class = TransportistaSerializer
    permission_classes = (permissions.IsAuthenticated,IsOwnerOrAdmin,)

class UserList(generics.ListAPIView):
    queryset = User.objects.all()
    serializer_class = UserSerializer
    permission_classes = (permissions.IsAuthenticated,IsOwnerOrAdmin,)

class UserDetail(generics.RetrieveAPIView):
    queryset = User.objects.all()
    serializer_class = UserSerializer
    permission_classes = (permissions.IsAuthenticated,IsOwnerOrAdmin,)
 
