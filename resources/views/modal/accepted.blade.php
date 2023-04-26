<div class="modal fade" role="dialog" id="arriveModal">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="jim-content">
                <h4>PATIENT ARRIVED</h4>
                <hr />
                <form method="post" id="arriveForm">
                    {{ csrf_field() }}
                    <div class="form-group-lg">
                        <div class="text-center text-bold text-success">
                            <small class="text-muted">Date/Time Arrived:</small><br />
                            {{ date('M d, Y h:i A') }}
                        </div>
                    </div>
                    <hr />
                    <div class="form-group-lg">
                        <label style="padding: 0px;">Remarks: </label>
                        <br />
                        <textarea name="remarks" class="remarks form-control" rows="5" style="resize: none"></textarea>
                    </div>
                    <hr />
                    <div class="form-fotter pull-right">
                        <button class="btn btn-default btn-flat" data-dismiss="modal"><i class="fa fa-times"></i> Close</button>
                        <button type="submit" class="btn btn-success btn-flat"><i class="fa fa-check"></i> Submit</button>
                    </div>
                </form>
                <div class="clearfix"></div>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->


<div class="modal fade" role="dialog" id="DoAModal">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="jim-content">
                <h4>DEAD ON ARRIVAL</h4>
                <hr />
                <form method="post" id="deadForm">
                    {{ csrf_field() }}
                    <div class="form-group-lg">
                        <div class="text-center text-bold text-success">
                            <small class="text-muted">Date/Time Dead on Arrival:</small><br />
                            {{ date('M d, Y h:i A') }}
                        </div>
                    </div>
                    <hr />
                    <div class="form-group-lg">
                        <label style="padding: 0px;">Remarks: </label>
                        <br />
                        <textarea name="remarks" class="remarks form-control" rows="5" style="resize: none"></textarea>
                    </div>
                    <hr />
                    <div class="form-fotter pull-right">
                        <button class="btn btn-default btn-flat" data-dismiss="modal"><i class="fa fa-times"></i> Close</button>
                        <button type="submit" class="btn btn-success btn-flat"><i class="fa fa-check"></i> Submit</button>
                    </div>
                </form>
                <div class="clearfix"></div>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div class="modal fade" role="dialog" id="archiveModal">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="jim-content">
                <h4>PATIENT DIDN'T ARRIVED</h4>
                <hr />
                <form method="post" id="archiveForm">
                    {{ csrf_field() }}
                    <div class="form-group-lg">
                        <label style="padding: 0px;">Remarks: </label>
                        <br />
                        <textarea name="remarks" class="remarks form-control" rows="5" style="resize: none"></textarea>
                    </div>
                    <hr />
                    <div class="form-fotter pull-right">
                        <button class="btn btn-default btn-flat" data-dismiss="modal"><i class="fa fa-times"></i> Close</button>
                        <button type="submit" class="btn btn-success btn-flat"><i class="fa fa-check"></i> Submit</button>
                    </div>
                </form>
                <div class="clearfix"></div>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div class="modal fade" role="dialog" id="admitModal">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="jim-content">
                <h4>ADMIT PATIENT</h4>
                <hr />
                <form method="post" id="admitForm">
                    {{ csrf_field() }}
                    <div class="form-group">
                        <label style="padding: 0px">Select Date/Time:</label>
                        <br />
                        <input type="text" value="{{ date('Y-m-d h:i:s A') }}" class="form-control form_datetime" name="date_time" placeholder="Date/Time Admitted" />
                    </div>
                    <hr />
                    <div class="form-fotter pull-right">
                        <button class="btn btn-default btn-flat" data-dismiss="modal"><i class="fa fa-times"></i> Close</button>
                        <button type="submit" class="btn btn-success btn-flat"><i class="fa fa-check"></i> Submit</button>
                    </div>
                </form>
                <div class="clearfix"></div>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->


<div class="modal fade" role="dialog" id="MonOPDModal">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="jim-content">
                <h4>PATIENT MONITORED AS OPD</h4>
                <hr />
                <form method="post" id="MonOPDForm">
                    {{ csrf_field() }}
                    <div class="form-group">
                        <label style="padding: 0px">Select Date/Time:</label>
                        <br />
                        <input type="text" value="{{ date('Y-m-d h:i:s A') }}" class="form-control form_datetime" name="date_time" placeholder="Date/Time Admitted" />
                    </div>
                    <hr />
                    <div class="form-fotter pull-right">
                        <button class="btn btn-default btn-flat" data-dismiss="modal"><i class="fa fa-times"></i> Close</button>
                        <button type="submit" class="btn btn-success btn-flat"><i class="fa fa-check"></i> Submit</button>
                    </div>
                </form>
                <div class="clearfix"></div>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div class="modal fade" role="dialog" id="dischargeModal">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="jim-content">
                <h4>DISCHARGE PATIENT</h4>
                <hr />
                <form method="post" id="dischargeForm">
                    {{ csrf_field() }}
                    <div class="form-group">
                        <label style="padding: 0px">Select Date/Time:</label>
                        <br />
                        <input type="text" value="{{ date('Y-m-d h:i:s A') }}" class="form-control form_datetime" name="date_time" placeholder="Date/Time Admitted" />
                    </div>
                    <div class="form-group">
                        <label style="padding: 0px">Clinical Status</label>
                        <br />
                        <select name="clinical_status" id="" class="form-control" >
                            <option value="">Select option</option>
                            <option value="asymptomatic">Asymptomatic for at least 3 days</option>
                            <option value="recovered">Recovered</option>
                            <option value="expired">Expired</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label style="padding: 0px">Surveillance Category</label>
                        <br />
                        <select name="sur_category" id="" class="form-control" >
                            <option value="">Select option</option>
                            <option value="contact_pum">Contact (PUM)</option>
                            <option value="suspect">Suspect</option>
                            <option value="probable">Probable</option>
                            <option value="confirmed">Confirmed</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label style="padding: 0px">Enter Remarks:</label>
                        <br />
                        <textarea name="remarks" class="remarks form-control" rows="5" style="resize: none" required></textarea>
                    </div>
                    <hr />
                    <div class="form-fotter pull-right">
                        <button class="btn btn-default btn-flat" data-dismiss="modal"><i class="fa fa-times"></i> Close</button>
                        <button type="submit" class="btn btn-success btn-flat"><i class="fa fa-check"></i> Submit</button>
                    </div>
                </form>
                <div class="clearfix"></div>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div class="modal fade" role="dialog" id="pregnantDisModal">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="jim-content">
                <h4>DISCHARGE PATIENT</h4>
                <hr />
                <form method="post" id="dischargeForm2"> 
                    {{ csrf_field() }}
                    <div class="form-group">
                        <label style="padding: 0px">Select Date/Time:</label>
                        <br />
                        <input type="text" value="{{ date('Y-m-d h:i:s A') }}" class="form-control form_datetime" name="date_time" placeholder="Date/Time Admitted" />
                    </div>
                    <div class="form-group">
                        <label style="padding: 0px">Delivery Outcome: </label>
                        <br />
                        <select name="delivery_outcome" class="form-control-select select2" required>
                            <option value="">Select Outcome...</option>
                            <option value="fullterm">Fullterm</option>
                            <option value="preterm">Preterm</option>
                            <option value="stillbirth">Stillbirth</option>
                            <option value="abortion">Abortion</option>
                        </select> 
                    </div>
                    <div class="form-group">
                        <label style="padding: 0px">Birth Attendant: </label>
                        <br />
                        <select name="birth_attendant" class="form-control-select select2" required>
                            <option value="">Select Attendant...</option>
                            <option value="md">MD</option>
                            <option value="rn">RN</option>
                            <option value="rm">RM</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label style="padding: 0px">Status on Discharge:</label>
                        <br />
                        <select name="status_on_discharge" class="form-control-select select2" required>
                            <option value="">Select Status...</option>
                            <option value="expired">Expired</option>
                            <option value="improved">Improved</option>
                            <option value="hama">HAMA</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label style="padding: 0px">Type of Delivery: </label>
                        <br />
                        <select name="type_of_delivery" class="form-control-select select2" required>
                            <option value="">Select Delivery...</option>
                            <option value="nsvd">Normal Spontaneous Vaginal Delivery (NSVD)</option>
                            <option value="caesarean">Caesarean</option>
                            <option value="vinal_after_caesarean">Vaginal Birth After Caesarean</option>
                            <option value="assisted_vaginal_delivery">Assisted Vaginal Delivery</option>
                        </select>
                    </div>
                    <div class="form-group">
                    <?php
                        $data = App\Diagnosis::where('void',0)
                        ->orderby('id','asc')
                        ->get();
                    ?>      
                        <label> Final Diagnosis with ICD 10 code:   </label> 
                        <br />  
                            <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/bbbootstrap/libraries@main/choices.min.css">
                            <script src="https://cdn.jsdelivr.net/gh/bbbootstrap/libraries@main/choices.min.js"></script>
                            <select name="final_diagnosis[]" id="choices-multiple-remove-button" class="form-control" style="width: 100%" required multiple>
                                @foreach($data as $dataa)
                                    <option defaultValue="{{ $dataa->id }}">{{ $dataa->diagcode }} {{ $dataa->diagdesc}}</option>
                                @endforeach
                            </select>
                    </div>
                    <div class="form-group">
                        <label style="padding: 0px">Enter Remarks:</label>
                        <br />
                        <textarea name="remarks" class="remarks form-control" rows="5" style="resize: none" required></textarea>
                    </div>
                    <hr />
                    <div class="form-fotter pull-right">
                        <button class="btn btn-default btn-flat" data-dismiss="modal"><i class="fa fa-times"></i> Close</button>
                        <button type="submit" class="btn btn-success btn-flat"><i class="fa fa-check"></i> Submit</button>
                    </div>
                </form>
                <div class="clearfix"></div>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

