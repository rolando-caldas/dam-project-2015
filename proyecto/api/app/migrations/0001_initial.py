# -*- coding: utf-8 -*-
from __future__ import unicode_literals

from django.db import migrations, models
import app.models


class Migration(migrations.Migration):

    dependencies = [
    ]

    operations = [
        migrations.CreateModel(
            name='Cliente',
            fields=[
                ('id', models.AutoField(verbose_name='ID', serialize=False, auto_created=True, primary_key=True)),
                ('cif', models.CharField(unique=True, max_length=100, validators=[app.models.validate_cif])),
                ('telefono', models.IntegerField(max_length=12)),
                ('denominacion_social', models.CharField(default=b'', max_length=255, blank=True)),
                ('direccion', models.TextField()),
            ],
            options={
                'ordering': ('cif',),
            },
        ),
    ]
