# -*- coding: utf-8 -*-
from __future__ import unicode_literals

from django.db import migrations, models
import django.utils.timezone


class Migration(migrations.Migration):

    dependencies = [
        ('app', '0006_auto_20151107_2102'),
    ]

    operations = [
        migrations.AlterField(
            model_name='entrega',
            name='fecha_entrega',
            field=models.DateTimeField(default=django.utils.timezone.now),
        ),
        migrations.AlterField(
            model_name='entrega',
            name='firma',
            field=models.TextField(null=True, blank=True),
        ),
        migrations.AlterField(
            model_name='entrega',
            name='observaciones',
            field=models.TextField(null=True, blank=True),
        ),
    ]
