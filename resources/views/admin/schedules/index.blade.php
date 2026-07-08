@extends('layouts.app')

@section('content')
    <style>
        .schedule-page {
            --primary: #2563eb;
            --dark: #0f172a;
            --muted: #64748b;
            --border: #e5e7eb;
        }


        /* HEADER */
        .schedule-banner {
            background:
                linear-gradient(135deg, #2563eb, #1d4ed8);
            padding: 28px;
            border-radius: 24px;
            color: white;
            box-shadow: 0 15px 35px rgba(37, 99, 235, .25);
        }


        .schedule-banner h3 {
            font-weight: 800;
            letter-spacing: -.5px;
        }


        .btn-create {
            background: white;
            color: #2563eb;
            padding: 12px 18px;
            border-radius: 14px;
            font-weight: 700;
            display: flex;
            align-items: center;
            gap: 8px;
            transition: .3s;
        }

        .btn-create:hover {
            transform: translateY(-2px);
            background: #eff6ff;
        }



        /* SUMMARY */
        .summary-card {
            background: white;
            border-radius: 20px;
            padding: 20px;
            border: 1px solid #eef2f7;
            box-shadow: 0 8px 25px rgba(15, 23, 42, .05);
        }

        .summary-title {
            font-size: 12px;
            color: #64748b;
            text-transform: uppercase;
            font-weight: 700;
        }

        .summary-value {
            font-size: 30px;
            font-weight: 800;
            color: #0f172a;
        }



        /* TABLE */
        .schedule-card {
            background: white;
            border-radius: 22px;
            overflow: hidden;
            border: 1px solid #eef2f7;
            box-shadow: 0 10px 30px rgba(15, 23, 42, .06);
        }


        .table thead th {
            background: #f8fafc;
            color: #64748b;
            font-size: 12px;
            font-weight: 800;
            text-transform: uppercase;
            padding: 16px;
            border: none;
        }


        .table tbody td {
            padding: 16px;
            vertical-align: middle;
            border-color: #f1f5f9;
        }


        .table tbody tr {
            transition: .25s;
        }


        .table tbody tr:hover {
            background: #f8fbff;
            transform: scale(1.002);
        }



        /* BADGE */

        .badge-soft {
            padding: 7px 12px;
            border-radius: 50px;
            font-size: 11px;
            font-weight: 800;
        }


        .blue {
            background: #eff6ff;
            color: #2563eb;
        }

        .green {
            background: #ecfdf5;
            color: #16a34a;
        }

        .yellow {
            background: #fffbeb;
            color: #d97706;
        }

        .red {
            background: #fef2f2;
            color: #dc2626;
        }



        .route-code {
            font-weight: 800;
            color: #0f172a;
            font-size: 15px;
        }


        .route-name {
            font-size: 13px;
            color: #64748b;
            margin-top: 3px;
        }



        /* ACTION */

        .action-btn {
            width: 38px;
            height: 38px;
            border-radius: 12px;
            display: inline-flex;
            justify-content: center;
            align-items: center;
            transition: .25s;
        }


        .action-btn:hover {
            transform: translateY(-3px);
        }
    </style>


    <div class="schedule-page container-fluid">


        <!-- HEADER -->

        <div class="schedule-banner mb-4 d-flex justify-content-between align-items-center">


            <div>

                <h3 class="mb-1">
                    Schedule Management
                </h3>

                <span class="opacity-75">
                    Manage operational route, vehicle and driver schedule
                </span>

            </div>



            <a href="{{ route('admin.schedules.create') }}" class="btn-create">

                <i class="ri-add-line"></i>
                New Schedule

            </a>


        </div>





        <!-- SUMMARY -->

        <div class="row g-3 mb-4">


            <div class="col-md-3">

                <div class="summary-card">

                    <div class="summary-title">
                        Total Schedule
                    </div>

                    <div class="summary-value">
                        {{ $schedules->count() }}
                    </div>

                </div>

            </div>



            <div class="col-md-3">

                <div class="summary-card">

                    <div class="summary-title">
                        Active
                    </div>

                    <div class="summary-value text-success">
                        {{ $schedules->where('is_active', 1)->count() }}
                    </div>

                </div>

            </div>




            <div class="col-md-3">

                <div class="summary-card">

                    <div class="summary-title">
                        Weekday
                    </div>

                    <div class="summary-value text-primary">
                        {{ $schedules->where('day_type', 'weekday')->count() }}
                    </div>

                </div>

            </div>




            <div class="col-md-3">

                <div class="summary-card">

                    <div class="summary-title">
                        Holiday
                    </div>

                    <div class="summary-value text-danger">
                        {{ $schedules->where('day_type', 'holiday')->count() }}
                    </div>

                </div>

            </div>



        </div>






        <!-- TABLE -->

        <div class="schedule-card">


            <div class="table-responsive">


                <table class="table mb-0">


                    <thead>

                        <tr>

                            <th>Route</th>
                            <th>Vehicle</th>
                            <th>Driver</th>
                            <th>Day</th>
                            <th>Time</th>
                            <th>Headway</th>
                            <th>Status</th>
                            <th class="text-center">
                                Action
                            </th>

                        </tr>

                    </thead>



                    <tbody>


                        @forelse($schedules as $s)
                            <tr>


                                <td>

                                    <div class="route-code">
                                        {{ $s->route->route_code ?? '-' }}
                                    </div>


                                    <div class="route-name">
                                        {{ $s->route->route_name ?? '-' }}
                                    </div>


                                </td>




                                <td>

                                    <span class="badge-soft blue">

                                        {{ $s->vehicle->plate_number ?? '-' }}

                                    </span>

                                </td>




                                <td>

                                    <b>
                                        {{ $s->driver->driver_name ?? ($s->driver->name ?? '-') }}
                                    </b>

                                </td>




                                <td>


                                    @php

                                        $dayClass = match ($s->day_type) {
                                            'weekday' => 'blue',
                                            'weekend' => 'yellow',
                                            'holiday' => 'red',
                                            default => 'green',
                                        };

                                    @endphp



                                    <span class="badge-soft {{ $dayClass }}">

                                        {{ strtoupper($s->day_type) }}

                                    </span>


                                </td>





                                <td>

                                    <strong>
                                        {{ $s->start_time }}
                                        -
                                        {{ $s->end_time }}
                                    </strong>

                                </td>




                                <td>

                                    {{ $s->headway_minutes ?? 0 }} min

                                </td>




                                <td>


                                    @if ($s->is_active)
                                        <span class="badge-soft green">
                                            ACTIVE
                                        </span>
                                    @else
                                        <span class="badge-soft red">
                                            INACTIVE
                                        </span>
                                    @endif


                                </td>




                                <td class="text-center">


                                    <a href="{{ route('admin.schedules.edit', $s->id) }}"
                                        class="btn btn-outline-warning action-btn">

                                        <i class="ri-edit-line"></i>

                                    </a>




                                    <form action="{{ route('admin.schedules.destroy', $s->id) }}" method="POST"
                                        class="d-inline">

                                        @csrf
                                        @method('DELETE')


                                        <button onclick="return confirm('Delete schedule?')"
                                            class="btn btn-outline-danger action-btn">

                                            <i class="ri-delete-bin-line"></i>

                                        </button>


                                    </form>


                                </td>



                            </tr>



                        @empty


                            <tr>

                                <td colspan="8" class="text-center py-5">


                                    <i class="ri-calendar-close-line fs-1 text-muted"></i>


                                    <div class="mt-2 text-muted">

                                        No schedule available

                                    </div>


                                </td>

                            </tr>
                        @endforelse



                    </tbody>


                </table>


            </div>


        </div>


    </div>
@endsection
