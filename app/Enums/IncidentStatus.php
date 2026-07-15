<?php

namespace App\Enums;


enum IncidentStatus: string
{
  case OPEN = 'open';
  case IN_PROGRESS = 'in_progress';
  case RESOLVED = 'resolved';
  case CLOSED = 'closed';
}
