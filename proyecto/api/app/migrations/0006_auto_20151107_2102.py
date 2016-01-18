# -*- coding: utf-8 -*-
from __future__ import unicode_literals

from django.db import migrations, models
import django.utils.timezone


class Migration(migrations.Migration):

    dependencies = [
        ('app', '0005_auto_20151107_1840'),
    ]

    operations = [
        migrations.AlterField(
            model_name='envio',
            name='fecha_creacion',
            field=models.DateTimeField(default=django.utils.timezone.now),
        ),
    ]
