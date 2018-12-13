<!-- Fonts -->
<link href="https://fonts.googleapis.com/css?family=Open+Sans|Poppins:200,500" rel="stylesheet">
<link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
<!-- Styles -->
<div class="container">
        <div class="card">
            <form method="post" action="https://codebreak.weareimd.be/dashboard/water/log">
                {{csrf_field()}}
                <div>
                    <label for="wateradd" class="col-12 col-form-label">Amount to add (liter)</label>
                    <div class="col-12">
                        <input type="number" id="wateradd" class="form-control" name="wateradd" min="0" max="100" step="0.01" value="0.00">
                    </div>
                </div>
                <div class="mt-3">
                    <div class="col-12">
                        <button type="submit" class="btn btn-success form-control" id="wateraddbutton">Log Water</button>
                    </div>
                </div>
            </form>
        </div>
    </div>