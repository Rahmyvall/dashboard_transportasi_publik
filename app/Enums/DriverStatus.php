<?php

namespace App\Enums;

enum DriverStatus: string
{
  case ACTIVE = 'active';
  case INACTIVE = 'inactive';
  case ON_DUTY = 'on_duty';

  /**
   * Label status dalam Bahasa Indonesia.
   */
  public function label(): string
  {
    return match ($this) {
      self::ACTIVE => 'Aktif',
      self::INACTIVE => 'Tidak Aktif',
      self::ON_DUTY => 'Sedang Bertugas',
    };
  }
}
