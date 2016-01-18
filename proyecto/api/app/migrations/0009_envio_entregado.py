# -*- coding: utf-8 -*-
from __future__ import unicode_literals

from django.db import migrations, models


class Migration(migrations.Migration):

    dependencies = [
        ('app', '0008_transportista_owner'),
    ]

    operations = [
        migrations.AddField(
            model_name='envio',
            name='entregado',
            field=models.BooleanField(default=False),
        ),
    ]
