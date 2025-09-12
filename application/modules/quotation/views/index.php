<?php
main_header(['quotation']);
$session = (object) get_userdata(USER);

// var_dump($items);
?>

<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Quotation</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active">Quotation List</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<section class="content">

    <div class="row">
        <div class="col-lg-8 col-md-6 col-sm-12">
            <div class="card card-gray-dark">
                <div class="card-header">
                    <h3 class="card-title">Quotation List :</h3>
                </div>

                <div class="row">
                    <div class="col-12">
                        <div class="card m-3">
                            <div class="card-body table-responsive p-0" style="height: 34.3rem;">
                                <table class="table table-hover text-nowrap">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Date Added</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody id="load_quotation">
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-md-6 col-sm-12">
            <div class="card card-gray-dark">
                <div class="card-header">
                    <h3 class="card-title">-</h3>
                </div>
                <form>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-6">
                                <button type="button" class="btn btn-primary" id="create_quotation"><b>Generate
                                        Quotation</b></button>
                            </div>
                            <div class="col-6">
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                    </div>
                </form>
            </div>
        </div>
    </div>

</section>

<!-- ############ PAGE END-->
<?php
main_footer();
?>
<script src="<?php echo base_url() ?>/assets/js/quotation/quotation.js"></script>
<script>
    $(document).ready(function () {
        load_quotation();
    });

    function load_quotation() {
        $(document).gmLoadPage({
            url: base_url + 'Quotation/load_quotation',
            load_on: '#load_quotation'
        });
    }


</script>