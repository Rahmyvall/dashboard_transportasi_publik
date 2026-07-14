<?php

namespace App\Enums;

enum TripStatus: string
{
  case Scheduled = 'scheduled';
  case Running = 'running';
  case Completed = 'completed';
  case Cancelled = 'cancelled';
  case Delayed = 'delayed';
}
