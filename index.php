<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Invoice Generator</title>
  <link rel="stylesheet" href="assets/css/bootstrap.min.css">
  <link rel="stylesheet" href="assets/css/style.css">
  <link rel="stylesheet" href="assets/css/invoice-style.css">
  <link rel="stylesheet" href="assets/css/cmxform.css">
  <link href="assets/font-awesome/css/all.css" rel="stylesheet">
  <script src="assets/js/jquery.min.js"></script>
  <script src="assets/js/jquery.validate.min.js"></script>
</head>
<body>
  <nav class = "navbar navbar-default" role = "navigation">
      <div class = "navbar-header">
        <a class = "navbar-brand">Invoice Generator</a>
      </div>
  </nav>

  <div class="container">
    <form id="invoice-generator-form">
    <div class="row clearfix mt-2">
      <div class="col-md-4">
        <table class="table table-bordered table-hover" id="tab_logic_total">
          <tbody>
            <tr>
              <th class="text-center">INVOICE NO</th>
              <td class="text-center">
                <input type="text" name='invoiceNumber' class="form-control" id="invoice-number" disabled/>
              </td>
            </tr>
            <tr>
              <th class="text-center">INVOICE DATE</th>
              <td class="text-center">
                <input type="date" class="form-control" name='invoiceDate' id="invoice-date" max="<?=date('Y-m-d');?>" required />
              </td>
            </tr>
          </tbody>
        </table>
      </div>
      <div class="col-md-4">
        <table class="table table-bordered table-hover" id="tab_logic_total">
          <tbody>
            <tr>
              <th class="text-center">BILL/SHIP TO</th>
              <td class="text-center">
                <input type="text" name='toName' placeholder='Enter name' class="form-control" id="to-name" required/>
              </td>
            </tr>
            <tr>
              <th class="text-center">ADDRESS</th>
              <td class="text-center">
                <textarea name='toAddress' id="to-address" placeholder='Enter address' class="form-control" required></textarea>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
      <div class="col-md-4">
        <table class="table table-bordered table-hover" id="tab_logic_total">
          <tbody>
            <tr>
              <th class="text-center">FROM</th>
              <td class="text-center">
                <input type="text" name='fromName' placeholder='Enter your company name' class="form-control" id="from-name" required />
              </td>
            </tr>
            <tr>
              <th class="text-center">ADDRESS</th>
              <td class="text-center">
                <textarea name='fromAddress' id="from-address" placeholder='Enter your company address' class="form-control" required ></textarea>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>


    <div class="row clearfix">
      <div class="col-md-12 table-responsive">
        <table class="table table-bordered table-hover m-2" id="tab_logic">
          <thead>
            <tr></tr>
              <th class="text-center"> Name </th>
              <th class="text-center"> Unit </th>
              <th class="text-center"> Unit Price($) </th>
              <th class="text-center"> Tax </th>
              <th class="text-center"> Total Amount </th>
              <th class="text-center"></th>
            </tr>
          </thead>
          <tbody id="invoice-table-body">
            <tr id="addr-0">
              <td><input type="text" name='name[]' id="name-0" placeholder='Enter the item name' class="form-control" required/></td>
              <td><input type="number" name='unit[]' id="unit-0" min="1" value="1"  placeholder='Enter unit' class="form-control unit" data-index="0" required /></td>
              <td><input type="number" name='unitPrice[]' id="unit-price-0" min="0.01" value="0.00" step=".01"  placeholder='Enter unit price' class="form-control unitPrice" data-index="0" required /></td>
              <td>
                <select name='tax[]' id="tax-0" class="form-control tax" data-index="0" required >
                  <option value="">Select Tax</option>
                  <option value="0">0%</option>
                  <option value="1">1%</option>
                  <option value="5">5%</option>
                  <option value="10">10%</option>
                </select>
              </td>
              <td><input type="text" name='amount[]' id="amount-0"  value='0.00' class="form-control amount" disabled/> <input type="text" name='taxAmount[]' id="taxAmount-0" value='0.00' class="taxAmount" hidden /></td>
              <td>
                <button onclick="clearRow(0)" type="button" class="btn btn-labeled btn-info">
                  <span class="btn-label"><em class="fas fa-sync"></em></span>
                </button>
              </td>
            </tr>

          </tbody>
        </table>
      </div>
    </div>
    <div class="row clearfix">
      <div class="col-md-12">
        <button type="button" id='add-row' class="pull-right btn btn-default">
          <span class="btn-label"><em class="fas fa-plus-circle"></em></span> Add Row
        </button>
      </div>
    </div>
    <div class="row clearfix mt-2">
      <div class="pull-right col-md-4">
        <table class="table table-bordered table-hover" id="tab_logic_total">
          <tbody>
            <tr>
              <th class="text-center">
                <span>Discount</span>
                <select id='discount' class="form-control discount">
                  <option value="PERCENTAGE">Percentage(%)</option>
                  <option value="AMOUNT">Amount ($)</option>
                </select>
              </th>
              <td class="text-center">
                <input type="number" name='discountValue' id="discount-value" min="0" value='0' max='100' class="form-control" required/>
              </td>
            </tr>

            <tr>
              <th class="text-center">Subtotal without tax</th>
              <td class="text-center">
                <input type="number" name='subTotalWithOutTax' value='0.00' step=".01" class="form-control" id="sub-total-without-tax" disabled/>
              </td>
            </tr>

            <tr>
              <th class="text-center">Subtotal with tax</th>
              <td class="text-center">
                <input type="number" name='subTotalWithTax' id="sub-total-with-tax" value='0.00' step=".01" class="form-control" disabled/>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
    <div class="text-center">
      <button type="submit" class="btn btn-labeled btn-success">
        <span class="btn-label"><em class="fas fa-print"></em></span> Generate Invoice
      </button>
      <button type="button" onClick="window.location.reload();" class="btn btn-labeled btn-info">
        <span class="btn-label"><em class="fas fa-sync"></em></span> Refresh
      </button>
    </div><br><br>
  </form>
  </div>

  <div id="invoiceholder">
  <div id="invoice" class="effect2">

    <div id="invoice-top">

      <div class="title">
        <h1>Invoice #<span class="invoiceVal invoice_num">tst-inv-23</span></h1>
        <p>Invoice Date: <span id="invoice_date">01 Feb 2018</span>
        </p>
      </div>
    </div>

    <div id="invoice-mid">
        <div class="clearfix">
            <div class="col-left">
                <p>BILL/SHIP TO:</p>
                <div class="clientinfo">
                    <h2 id="supplier">TESI S.P.A.</h2>
                    <p><span id="address">VIA SAVIGLIANO, 48</span><br><span id="city">RORETO DI CHERASCO</span><br><span id="country">IT</span> - <span id="zip">12062</span><br><span id="tax_num">555-555-5555</span><br></p>
                </div>
            </div>
            <div class="col-right">
              <p>FROM:</p>
              <div class="clientinfo">
                  <h2 id="supplier">TESI S.P.A.</h2>
                  <p><span id="address">VIA SAVIGLIANO, 48czdczdczascascascdacsacs</span><br><span id="city">RORETO DI CHERASCO</span><br><span id="country">IT</span> - <span id="zip">12062</span><br><span id="tax_num">555-555-5555</span><br></p>
              </div>
            </div>
        </div>
    </div>

    <div id="invoice-bot">
      <div id="table">
        <table class="table-main">
          <thead>
              <tr class="tabletitle">
                <th>Type</th>
                <th>Description</th>
                <th>Quantity</th>
                <th>Unit Price</th>
                <th>Total</th>
              </tr>
          </thead>
          <tr class="list-item">
            <td data-label="Type" class="tableitem">ITEM</td>
            <td data-label="Description" class="tableitem">Servizio EDI + Traffico mese di novembre 2017</td>
            <td data-label="Quantity" class="tableitem">46.6</td>
            <td data-label="Unit Price" class="tableitem">1</td>
            <td data-label="Total" class="tableitem">55.92</td>
          </tr>
         <tr class="list-item">
            <td data-label="Type" class="tableitem">ITEM</td>
            <td data-label="Description" class="tableitem">Traffico mese di novembre 2017 FRESSNAPF TIERNAHRUNGS GMBH riadd. Almo DE</td>
            <td data-label="Quantity" class="tableitem">4.4</td>
            <td data-label="Unit Price" class="tableitem">1</td>
            <td data-label="Total" class="tableitem">55.92</td>
          </tr>
        </table>
      </div>

      <br><div class="col-right">
        <table class="table">
            <tbody>
                <tr>
                    <td><span>Invoice Total</span><label id="invoice_total">61.2</label></td>
                    <td><span>Currency</span><label id="currency">EUR</label></td>
                </tr>
                <tr>
                    <td><span>Payment Term</span><label id="payment_term">60 gg DFFM</label></td>
                    <td><span>Invoice Type</span><label id="invoice_type">EXP REP INV</label></td>
                </tr>
                <tr><td colspan="2"><span>Note</span>#<label id="note">None</label></td></tr>
            </tbody>
        </table>
    </div><br>
    </div>
  </div>
</div>

  <script src="assets/js/bootstrap.min.js"></script>
  <script src="assets/js/main.js"></script>
</body>
</html>
