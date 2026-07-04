<?php

/*
 * Project Name: easy-ticket-ai
 * File: UtilsHelper.php
 * Created Date: 2026-07-05 22.40
 * Last Modified Date: 2026-07-05 22.40
 *
 * Author: Nova Ardiansyah admin@novaardiansyah.id
 * Website: https://novaardiansyah.id
 * MIT License: https://github.com/novaardiansyah/easy-ticket-ai/blob/main/LICENSE
 *
 * Copyright (c) 2026 Nova Ardiansyah, Org
 */

function template(string $path = '')
{
	return url('template/' . $path);
}
