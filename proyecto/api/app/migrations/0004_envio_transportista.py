# -*- coding: utf-8 -*-
from __future__ import unicode_literals

from django.db import migrations, models
import django.db.models.deletion


class Migration(migrations.Migration):

    dependencies = [
        ('app', '0003_auto_20151107_1838'),
    ]

    operations = [
        migrations.AddField(
            model_name='envio',
            name='transportista',
            field=models.ForeignKey(related_name='transportista', on_delete=django.db.models.deletion.SET_NULL, blank=True, to='app.Transportista', null=True),
        ),
    ]
