<div class="row">
  <div class="col-xs-12 ">
    <div class="panel {panelColor}">
      <div class="panel-heading" style="padding-top:4px;padding-bottom:0px">
        <div class="row">
          <div class="col-sm-11" style="padding-top:6px;padding-bottom:6px">
            <h3 class="panel-title ">
              {vacCode} - {vacTitle} <small></small>
            </h3>
          </div>
          <div class="col-sm-1">
            <div class="btn-group pull-right">
              <button type="button" class="btn btn-link dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                Action <span class="caret"></span>
              </button>
              <ul class="dropdown-menu" data-id={vacId}>
                <li><a href="#" class="btn-edit"><i class="fa fa-pencil"></i> Edit</a></li>
                <li><a href="<?php echo site_url('vacancy/processPublish')?>" class="btn-publish">{pubStatus}</a></li>
                <li role="separator" class="divider"></li>
                <li><a href="#" class="btn-remove"><i class="fa fa-trash"></i> Remove</a></li>
              </ul>
            </div>

          </div>

        </div>
      </div>
      <div class="panel-body" style="padding:0px">
        <ul class="nav nav-pills nav-justified thumbnail" style="margin-bottom:0px">
          {phase}
          <li><a href="{selectUrl}" title="Click to selection">
            <h4 class="list-group-item-heading">{phaseName}</h4>
            <p class="list-group-item-text">{appNum} Candidate(s)</p>
          </a></li>
          {/phase}
          <li><a href="#">
            <h4 class="list-group-item-heading">Hired/ Rejected</h4>
            <p class="list-group-item-text"> {hiredNum} / {rejectNum} Candidate(s)</p>
          </a></li>
        </ul>
      </div>
    </div>
  </div>
</div>
