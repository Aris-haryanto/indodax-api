
  <section class="jumbotron text-center">
    <div class="container">
        <div class="row">
            <div class="col-md-5" style="text-align: left">
                <?php if(isset($data['return']['profile_picture'])){ ?>
                    <img width="200" class="rounded-circle" alt="Profile Picture" src="<?= $data['return']['profile_picture']; ?>" /><br><br>
                <? } ?>
                <h5>Name : <?= $data['return']['name']; ?></h5>
                <h5>Email : <?= $data['return']['email']; ?></h5>
                <h5>Saldo : <?= $data['return']['balance']['idr']; ?> IDR</h5>
            </div><br>
            <div class="col-md" style="width: 500px;">
                <form method="POST" action="<?php echo base_url(); ?>trading">
                    <input type="hidden" name="<?= $csrf['name']; ?>" value="<?= $csrf['hash']; ?>" />
                    <input type="hidden" name="type" value="buy" />
                    <div class="form-group row">
                        <label for="coin" class="col-sm-2 col-form-label">Coin</label>
                        <div class="col-sm-10">
                            <select id="coin" name="pair" class="form-control">
                                <?php 
                                $coin = $data['return']['balance'];
                                unset($coin['idr']);
                                foreach ($coin as $key => $val) { ?>
                                    <option value="<?php echo $key; ?>_idr"><?php echo strtoupper($key); ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="amount" class="col-sm-2 col-form-label">Amount</label>
                        <div class="col-sm-10">
                            <input type="number" id="amount" name="amount" min="0" value="<?= $data['return']['balance']['idr']; ?>" max="<?php echo $data['return']['balance']['idr']; ?>" class="form-control" />
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="price" class="col-sm-2 col-form-label">Price</label>
                        <div class="col-sm-10">
                            <input type="number" id="price" name="price" value="0" class="form-control" />
                            <span class="error"><?=$error?></span>
                        </div>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="float-right btn btn-success">Buy</button>
                    </div>
                    <div class="clearfix"></div>
                </form>
            </div>
        </div><br>



        <div class="row">
            <div class="col-md-4 table-responsive">
                <h3>Balance</h3>
                <table class="table table-striped">
                    <thead>
                        <tr>
                          <th scope="col">Coin</th>
                          <th scope="col">Value</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($data['return']['balance'] as $key => $val) { ?>
                            <tr>
                              <td><?php echo strtoupper($key); ?></td>
                              <td><?php echo $val; ?></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
              </div>


              <div class="col-md table-responsive">
                <?php 
                if(isset($pending['return']['orders'])){ ?>
                    <h3>Pending Orders</h3>
                    <?php foreach ($pending['return']['orders'] as $keys => $value) { ?>
                    <h4 style="text-align: left;"><?= strtoupper($keys); ?></h4>
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                  <th scope="col">Order ID</th>
                                  <th scope="col">Submit Time</th>
                                  <th scope="col">Price</th>
                                  <th scope="col">Type</th>
                                  <th scope="col">Order IDR</th>
                                  <th scope="col">Remain IDR</th>
                                  <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($value as $key => $val) { ?>

                    <?php #print_r($val['order_id']); ?>
                                    <tr>
                                      <td><?php echo $val['order_id']; ?></td>
                                      <td><?php echo gmdate("j F Y H:i:s", $val['submit_time']); ?></td>
                                      <td><?php echo $val['price']; ?></td>
                                      <td><?php echo $val['type']; ?></td>
                                      <td><?php echo $val['order_idr']; ?></td>
                                      <td><?php echo $val['remain_idr']; ?></td>
                                      <td><a onclick="return confirm('Are You Sure ?')" href="<?php echo base_url(); ?>cancelorder?pair=<?=$keys?>&order_id=<?=$val['order_id'];?>&type=<?=$val['type'];?>" class="btn btn-danger">Cancel</a></td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table> 
                <?php } 
                }else{ ?>
                    <h3>No Pending Orders</h3>
                <?php } ?>
              </div>
          
        </div>
    </div>
  </section>