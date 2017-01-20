<div class="row">
  <div class="col-xs-12 ">
    <div class="panel {panelColor}">
      <div class="panel-heading">
        <h3 class="panel-title">
          {vacCode} - {vacTitle} <small></small>
          <a class="btn-edit pull-right" href="{editUrl}" title="Edit Vacancy"><i class="fa fa-pencil"></i></a>
          <a  class="btn-publish pull-right" href="{publishUrl}" title="{pubTool}"><i class="fa {pubIcon}"></i></a>

        </h3>
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
