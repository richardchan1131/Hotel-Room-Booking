
<?php $__env->startSection('content'); ?>
    <div class="bravo-user-dashboard">
        <div class="row y-gap-20 justify-between items-end pb-60 lg:pb-40 md:pb-32">
            <div class="col-auto">
                <h1 class="text-30 lh-14 fw-600"><?php echo e(__("Dashboard")); ?></h1>
                <div class="text-15 text-light-1"><?php echo e(__("Ready to jump back in?")); ?></div>
            </div>
            <div class="col-auto">
            </div>
        </div>

        <?php echo $__env->make('admin.message', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

        <div class="row y-gap-30">
            <?php if(!empty($cards_report)): ?>
                <?php $__currentLoopData = $cards_report; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="col-xl-3 col-md-6">
                        <div class="py-30 px-30 rounded-4 bg-white shadow-3">
                            <div class="row y-gap-20 justify-between items-center">
                                <div class="col-auto">
                                    <div class="fw-500 lh-14"><?php echo e($item['title']); ?></div>
                                    <div class="text-26 lh-16 fw-600 mt-5"><?php echo e($item['amount']); ?></div>
                                    <div class="text-15 lh-14 text-light-1 mt-5"><?php echo e($item['desc']); ?></div>
                                </div>

                                <div class="col-auto">
                                    <img src="<?php echo e(asset('/themes/gotrip/images/user/dashboard/'. ($key + 1) . '.svg')); ?>" alt="icon">
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <?php endif; ?>
        </div>

        <div class="row y-gap-30 pt-20">
            <div class="col-xl-7 col-md-6">
                <div class="py-30 px-30 rounded-4 bg-white shadow-3">
                    <div class="d-flex justify-between items-center">
                        <h2 class="text-18 lh-1 fw-500">
                            <?php echo e(__("Earning Statistics")); ?>

                        </h2>
                        <div class="action-control d-flex items-center bg-white border-light rounded-100 px-15 py-10 text-14 lh-12">
                            <div id="reportrange">
                                <i class="fa fa-calendar"></i>&nbsp;
                                <span></span> <i class="fa fa-caret-down"></i>
                            </div>
                        </div>
                    </div>

                    <div class="pt-30">
                        <canvas class="bravo-user-render-chart"></canvas>
                        <script>
                            var earning_chart_data = <?php echo json_encode($earning_chart_data); ?>;
                        </script>
                    </div>
                </div>
            </div>

            <div class="col-xl-5 col-md-6">
                <div class="py-30 px-30 rounded-4 bg-white shadow-3">
                    <div class="d-flex justify-between items-center">
                        <h2 class="text-18 lh-1 fw-500">
                            <?php echo e(__("Recent Bookings")); ?>

                        </h2>

                        <div class="">
                            <a href="<?php echo e(route('vendor.bookingReport')); ?>" class="text-14 text-blue-1 fw-500 underline"><?php echo e(__("View All")); ?></a>
                        </div>
                    </div>

                    <div class="overflow-scroll scroll-bar-1 pt-30">
                        <table class="table-2 col-12">
                            <thead class="">
                            <tr>
                                <th>#</th>
                                <th><?php echo e(__("Item")); ?></th>
                                <th><?php echo e(__("Total")); ?></th>
                                <th><?php echo e(__("Paid")); ?></th>
                                <th><?php echo e(__("Status")); ?></th>
                                <th><?php echo e(__("Created At")); ?></th>
                            </tr>
                            </thead>
                            <tbody>

                            <?php if($recent_bookings): ?>
                                <?php $__currentLoopData = $recent_bookings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td>#<?php echo e($val->id); ?></td>
                                        <td><?php echo e($val->service->title ?? ''); ?></td>
                                        <td class="fw-500"><?php echo e(format_money($val->total)); ?></td>
                                        <td><?php echo e(format_money($val->paid)); ?></td>
                                        <td>
                                            <?php
                                                switch ($val->status){
                                                    case "unpaid":
                                                    case "processing":
                                                    case "pending":
                                                        $status_class = 'bg-yellow-4 text-yellow-3';
                                                        break;
                                                    case "partial_payment":
                                                        $status_class = 'bg-blue-1-05 text-blue-1';
                                                        break;
                                                    case "paid":
                                                    case "completed":
                                                    case "confirmed":
                                                        $status_class = 'bg-green-1 text-green-2';
                                                        break;
                                                    case "cancelled":
                                                    case "cancel":
                                                        $status_class = 'bg-border text-black';
                                                        break;
                                                    case "fail":
                                                        $status_class = 'bg-red-3 text-red-2';
                                                        break;
                                                    default:
                                                        $status_class = 'bg-light-2 text-light-1';
                                                        break;
                                                }
                                            ?>
                                            <div class="rounded-100 py-4 text-center col-12 text-14 fw-500 <?php echo e($status_class); ?>"><?php echo e(booking_status_to_text($val->status)); ?></div>
                                        </td>
                                        <td><?php echo e(display_date(strtotime($val->created_at))); ?><br><?php echo e(date('H:i', strtotime($val->created_at))); ?></td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="6" class="text-center"><?php echo e(__("No booking")); ?></td>
                                </tr>
                            <?php endif; ?>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

<?php $__env->stopSection(); ?>
<?php $__env->startPush('js'); ?>
    <script type="text/javascript" src="<?php echo e(asset("libs/chart_js/Chart.min.js")); ?>"></script>
    <script type="text/javascript">
        jQuery(function ($) {
            $(".bravo-user-render-chart").each(function () {
                let ctx = $(this)[0].getContext('2d');
                window.myMixedChartForVendor = new Chart(ctx, {
                    type: 'bar',//line - bar
                    data: earning_chart_data,
                    options: {
                        min:0,
                        responsive: true,
                        legend: {
                            display: true
                        },
                        scales: {
                            xAxes: [{
                                stacked: true,
                                display: true,
                                scaleLabel: {
                                    labelString: '<?php echo e(__("Timeline")); ?>'
                                }
                            }],
                            yAxes: [{
                                stacked: true,
                                display: true,
                                scaleLabel: {
                                    display: true,
                                    labelString: '<?php echo e(__("Currency: :currency_main",['currency_main'=>setting_item('currency_main')])); ?>'
                                },
                                ticks: {
                                    beginAtZero: true,
                                }
                            }]
                        },
                        tooltips: {
                            callbacks: {
                                label: function (tooltipItem, data) {
                                    var label = data.datasets[tooltipItem.datasetIndex].label || '';
                                    if (label) {
                                        label += ': ';
                                    }
                                    label += tooltipItem.yLabel + " (<?php echo e(setting_item('currency_main')); ?>)";
                                    return label;
                                }
                            }
                        }
                    }
                });
            });
            $(".bravo-user-chart form select").change(function () {
                $(this).closest("form").submit();
            });

            var start = moment().startOf('week');
            var end = moment();
            function cb(start, end) {
                $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
            }
            $('#reportrange').daterangepicker({
                startDate: start,
                endDate: end,
                "alwaysShowCalendars": true,
                "opens": "left",
                "showDropdowns": true,
                ranges: {
                    '<?php echo e(__("Today")); ?>': [moment(), moment()],
                    '<?php echo e(__("Yesterday")); ?>': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                    '<?php echo e(__("Last 7 Days")); ?>': [moment().subtract(6, 'days'), moment()],
                    '<?php echo e(__("Last 30 Days")); ?>': [moment().subtract(29, 'days'), moment()],
                    '<?php echo e(__("This Month")); ?>': [moment().startOf('month'), moment().endOf('month')],
                    '<?php echo e(__("Last Month")); ?>': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')],
                    '<?php echo e(__("This Year")); ?>': [moment().startOf('year'), moment().endOf('year')],
                    '<?php echo e(__('This Week')); ?>': [moment().startOf('week'), end]
                }
            }, cb).on('apply.daterangepicker', function (ev, picker) {
                $.ajax({
                    url: '<?php echo e(url('user/reloadChart')); ?>',
                    data: {
                        chart: 'earning',
                        from: picker.startDate.format('YYYY-MM-DD'),
                        to: picker.endDate.format('YYYY-MM-DD'),
                    },
                    dataType: 'json',
                    type: 'post',
                    success: function (res) {
                        if (res.status) {
                            window.myMixedChartForVendor.data = res.data;
                            window.myMixedChartForVendor.update();
                        }
                    }
                })
            });
            cb(start, end);
        });
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.user', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/r114961reze/public_html/themes/GoTrip/User/Views/frontend/dashboard.blade.php ENDPATH**/ ?>