# -*- coding: utf-8 -*-
from __future__ import unicode_literals

from django.db import migrations, models
import django.db.models.deletion


class Migration(migrations.Migration):

    dependencies = [
        ('app', '0004_envio_transportista'),
    ]

    operations = [
        migrations.AddField(
            model_name='entrega',
            name='transportista',
            field=models.ForeignKey(related_name='entrega_transportista', on_delete=django.db.models.deletion.SET_NULL, blank=True, to='app.Transportista', null=True),
        ),
        migrations.AlterField(
            model_name='entrega',
            name='envio',
            field=models.ForeignKey(related_name='entrega_envio', on_delete=django.db.models.deletion.SET_NULL, blank=True, to='app.Envio', null=True),
        ),
        migrations.AlterField(
            model_name='envio',
            name='cliente',
            field=models.ForeignKey(related_name='envio_cliente', on_delete=django.db.models.deletion.SET_NULL, blank=True, to='app.Cliente', null=True),
        ),
        migrations.AlterField(
            model_name='envio',
            name='transportista',
            field=models.ForeignKey(related_name='envio_transportista', on_delete=django.db.models.deletion.SET_NULL, blank=True, to='app.Transportista', null=True),
        ),
    ]
