@extends('admin.admin_master')
@section('admin')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/handlebars.js/4.7.6/handlebars.min.js"></script>

    <div class="content-wrapper">
        <div class="container-full">
            <!-- Content Header (Page header) -->


            <!-- Main content -->
            <section class="content">
                <div class="row">


                    <div class="col-12">
                        <div class="box bb-3 border-warning">
                            <div class="box-header">
                                <h4 class="box-title">Student <strong>Registration Fee</strong></h4>
                            </div>

                            <div class="box-body">


                                <div class="row">

                                    <div class="col-md-4" style="padding-top: 25px;">

                                        <a id="search" class="btn btn-primary" name="search"> Generate Student Fee</a>



                                    </div> <!-- End Col md 4 -->
                                </div><!--  end row -->


                                <!--  ////////////////// Registration Fee table /////////////  -->


                                <div class="row">
                                    <div class="col-md-12">
                                        <div id="DocumentResults">

                                            <script id="document-template" type="text/x-handlebars-template">

                                                <table class="table table-bordered table-striped" style="width: 100%">
                                                    <thead>
                                                    <tr>
                                                        @{{{thsource}}}
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    @{{#each this}}
                                                    <tr>
                                                        @{{{tdsource}}}
                                                    </tr>
                                                    @{{/each}}
                                                    </tbody>
                                                </table>
                                            </script>


                                        </div>
                                    </div>

                                </div>


                            </div>
                            <!-- /.col -->
                        </div>
                        <!-- /.row -->
            </section>
            <!-- /.content -->

        </div>
    </div>


    <script type="text/javascript">
        $(document).on('click', '#search', function () {
            var year_id = $('#year_id').val();
            var class_id = $('#class_id').val();
            $.ajax({
                url: "{{ route('student.registration.fee.singular.classwise.get')}}",
                type: "get",
                data: {'year_id': year_id, 'class_id': class_id},
                beforeSend: function () {
                },
                success: function (data) {
                    var source = $("#document-template").html();
                    var template = Handlebars.compile(source);
                    var html = template(data);
                    $('#DocumentResults').html(html);
                    $('[data-toggle="tooltip"]').tooltip();
                }
            });
        });

    </script>

@endsection
