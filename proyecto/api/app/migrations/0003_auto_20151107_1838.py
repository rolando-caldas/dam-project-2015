# -*- coding: utf-8 -*-
from __future__ import unicode_literals

from django.db import migrations, models
import django.db.models.deletion
import app.models


class Migration(migrations.Migration):

    dependencies = [
        ('app', '0002_auto_20151107_1720'),
    ]

    operations = [
        migrations.CreateModel(
            name='Entrega',
            fields=[
                ('id', models.AutoField(verbose_name='ID', serialize=False, auto_created=True, primary_key=True)),
                ('fecha_entrega', models.DateTimeField()),
                ('firma', models.TextField()),
                ('observaciones', models.TextField()),
            ],
        ),
        migrations.CreateModel(
            name='Envio',
            fields=[
                ('id', models.AutoField(verbose_name='ID', serialize=False, auto_created=True, primary_key=True)),
                ('destinatario', models.CharField(max_length=255)),
                ('direccion', models.TextField()),
                ('fecha_creacion', models.DateTimeField()),
                ('cliente', models.ForeignKey(related_name='cliente', on_delete=django.db.models.deletion.SET_NULL, blank=True, to='app.Cliente', null=True)),
            ],
            options={
                'ordering': ('fecha_creacion',),
            },
        ),
        migrations.CreateModel(
            name='Transportista',
            fields=[
                ('id', models.AutoField(verbose_name='ID', serialize=False, auto_created=True, primary_key=True)),
                ('apellidos', models.CharField(max_length=255)),
                ('nif', models.CharField(unique=True, max_length=100, validators=[app.models.validate_nif])),
                ('nombre', models.CharField(max_length=100)),
                ('telefono', models.IntegerField()),
            ],
            options={
                'ordering': ('nif',),
            },
        ),
        migrations.AddField(
            model_name='entrega',
            name='envio',
            field=models.ForeignKey(related_name='envio', on_delete=django.db.models.deletion.SET_NULL, blank=True, to='app.Envio', null=True),
        ),
    ]
