<div class="modal fade" tabindex="-1" id="add-task-modal">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <form id="form-addtask" action="/tasks/create" method="POST">
        <div class="modal-header">
          <h5 class="modal-title">Add Task</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="alert alert-danger" style="display:none" id="alert"><ul class="error-list"></ul></div>
          
          {{ csrf_field() }}
          <div class="form-group">
            <label for="contract-employee-name">Name</label>
            <input type="text" name="name" class="form-control">
          </div>

          <div class="form-group">
            <label for="contract-employee-name">Name</label>
            <select name="project" id="project-dropdown" class="form-control">
              @foreach($projects as $project)
              <option value="{{ $project->id }}">{{ $project->name }}</option>
              @endforeach
            </select>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <input type="submit" id="btn-submit-task" class="btn btn-primary" value="Add" />
        </div>
      </form>
    </div>
  </div>
</div>