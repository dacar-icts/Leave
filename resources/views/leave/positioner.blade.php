<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Drag & Drop Field Positioner</title>
  <style>
    body { background: #eee; }
    .container {
      position: relative;
      width: 850px;
      height: 1200px;
      margin: 30px auto;
      background: #fff;
      border: 1px solid #ccc;
    }
    .form-bg {
      position: absolute;
      top: 0; left: 0;
      width: 100%; height: 100%;
      z-index: 1;
      user-select: none;
      pointer-events: none;
    }
    .draggable {
      position: absolute;
      z-index: 2;
      background: rgba(0, 150, 255, 0.15);
      border: 1px solid #2196f3;
      border-radius: 4px;
      padding: 4px 10px;
      cursor: move;
      font-size: 14px;
      color: #222;
      min-width: 80px;
      min-height: 20px;
      user-select: none;
      transition: box-shadow 0.2s;
    }
    .draggable:active {
      box-shadow: 0 0 8px #2196f3;
    }
    .label {
      font-size: 12px;
      color: #1976d2;
      font-weight: bold;
      margin-bottom: 2px;
      display: block;
    }
  </style>
</head>
<body>
  <div class="container" id="container">
    <img src="{{ asset('cs_form_6_bg.png') }}" class="form-bg" alt="Form Background">
    <!-- Draggable fields will be injected here -->
  </div>
  <script>
    // List of user-editable fields
    const fields = [
      'office',
      'name',
      'filing_date',
      'position',
      'salary',
      'leave_type',
      'leave_type_other',
      'within_ph',
      'within_ph_details',
      'abroad',
      'abroad_details',
      'in_hospital',
      'in_hospital_details',
      'out_patient',
      'out_patient_details',
      'special_leave_benefits',
      'special_leave_details',
      'completion_masters',
      'bar_exam',
      'monetization',
      'terminal_leave',
      'num_days',
      'inclusive_dates',
      'commutation'
    ];

    const container = document.getElementById('container');

    // Initial positions (stacked for easy finding)
    fields.forEach((field, i) => {
      const div = document.createElement('div');
      div.className = 'draggable';
      div.id = 'field-' + field;
      div.style.top = (30 + i * 40) + 'px';
      div.style.left = '20px';
      div.innerHTML = `<span class="label">${field}</span>Drag me`;
      makeDraggable(div);
      container.appendChild(div);
    });

    function makeDraggable(el) {
      let offsetX, offsetY, startX, startY, dragging = false;

      el.addEventListener('mousedown', function(e) {
        dragging = true;
        startX = e.clientX;
        startY = e.clientY;
        offsetX = parseInt(el.style.left) || 0;
        offsetY = parseInt(el.style.top) || 0;
        el.style.zIndex = 10;
        document.body.style.userSelect = 'none';
      });

      document.addEventListener('mousemove', function(e) {
        if (!dragging) return;
        let dx = e.clientX - startX;
        let dy = e.clientY - startY;
        let newLeft = offsetX + dx;
        let newTop = offsetY + dy;
        // Boundaries
        newLeft = Math.max(0, Math.min(newLeft, container.offsetWidth - el.offsetWidth));
        newTop = Math.max(0, Math.min(newTop, container.offsetHeight - el.offsetHeight));
        el.style.left = newLeft + 'px';
        el.style.top = newTop + 'px';
      });

      document.addEventListener('mouseup', function(e) {
        if (!dragging) return;
        dragging = false;
        el.style.zIndex = 2;
        document.body.style.userSelect = '';
        // Log the CSS for this field
        console.log(`.${el.id} { top: ${el.style.top}; left: ${el.style.left}; }`);
      });
    }
  </script>
</body>
</html> 