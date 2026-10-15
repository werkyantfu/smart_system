#!/bin/bash

clear

echo "═══════════════════════════════════════════════════════"
echo "🔄 BACKEND → FRONTEND FLOW CHECK"
echo "📅 $(date)"
echo "═══════════════════════════════════════════════════════"
echo ""

# ═══════════════════════════════════════════
# PART 1: BACKEND STRUCTURE
# ═══════════════════════════════════════════
echo "🔵 BACKEND STRUCTURE"
echo "─────────────────────────────────────────────────────"
echo ""

echo "📁 Models ($(ls backend/app/Models/*.php 2>/dev/null | wc -l)):"
for model in User Student Teacher ClassRoom Subject Attendance Mark Fee Payment LibraryBook Announcement School; do
  [ -f "backend/app/Models/${model}.php" ] && echo "   ✅ $model.php" || echo "   ❌ $model.php"
done
echo ""

echo "📁 Controllers ($(ls backend/app/Http/Controllers/Api/*.php 2>/dev/null | wc -l)):"
for ctrl in Auth Student Teacher Class Subject Attendance Mark Fee Payment Library Announcement Dashboard Report User School; do
  [ -f "backend/app/Http/Controllers/Api/${ctrl}Controller.php" ] && echo "   ✅ ${ctrl}Controller.php" || echo "   ❌ ${ctrl}Controller.php"
done
echo ""

echo "📁 Routes:"
[ -f "backend/routes/api.php" ] && echo "   ✅ api.php ($(grep -c 'Route::' backend/routes/api.php) routes)" || echo "   ❌ api.php"
echo ""

# ═══════════════════════════════════════════
# PART 2: FRONTEND STRUCTURE
# ═══════════════════════════════════════════
echo "🟢 FRONTEND STRUCTURE"
echo "─────────────────────────────────────────────────────"
echo ""

echo "📁 Services ($(ls frontend/src/services/*.js 2>/dev/null | wc -l)):"
for svc in api authService studentService teacherService classService subjectService attendanceService markService feeService libraryService announcementService; do
  [ -f "frontend/src/services/${svc}.js" ] && echo "   ✅ ${svc}.js" || echo "   ❌ ${svc}.js"
done
echo ""

echo "📁 Stores ($(ls frontend/src/stores/*.js 2>/dev/null | wc -l)):"
for store in auth student teacher class subject attendance mark fee library announcement dashboard; do
  [ -f "frontend/src/stores/${store}.js" ] && echo "   ✅ ${store}.js" || echo "   ❌ ${store}.js"
done
echo ""

echo "📁 Views ($(ls frontend/src/views/*.vue 2>/dev/null | wc -l)):"
for view in Home Login Dashboard Students Teachers Classes Subjects Attendance Marks Fees Library Announcements Reports Settings; do
  [ -f "frontend/src/views/${view}View.vue" ] && echo "   ✅ ${view}View.vue" || echo "   ❌ ${view}View.vue"
done
echo ""

# ═══════════════════════════════════════════
# PART 3: FLOW MATCH (Student Example)
# ═══════════════════════════════════════════
echo "🔄 FLOW MATCHING (Student Module Example)"
echo "─────────────────────────────────────────────────────"
echo ""

echo "1️⃣  BACKEND:"
[ -f "backend/app/Models/Student.php" ] && echo "   ✅ Model: backend/app/Models/Student.php" || echo "   ❌ Model MISSING"
[ -f "backend/app/Http/Controllers/Api/StudentController.php" ] && echo "   ✅ Controller: backend/app/Http/Controllers/Api/StudentController.php" || echo "   ❌ Controller MISSING"
grep -q "students" backend/routes/api.php && echo "   ✅ Route: /api/students defined" || echo "   ❌ Route MISSING"
echo ""

echo "2️⃣  FRONTEND:"
[ -f "frontend/src/services/api.js" ] && echo "   ✅ Axios: frontend/src/services/api.js" || echo "   ❌ Axios MISSING"
[ -f "frontend/src/services/studentService.js" ] && echo "   ✅ Service: frontend/src/services/studentService.js" || echo "   ❌ Service MISSING"
[ -f "frontend/src/stores/student.js" ] && echo "   ✅ Store: frontend/src/stores/student.js" || echo "   ❌ Store MISSING"
[ -f "frontend/src/views/StudentsView.vue" ] && echo "   ✅ View: frontend/src/views/StudentsView.vue" || echo "   ❌ View MISSING"
echo ""

# ═══════════════════════════════════════════
# PART 4: CONNECTION CHECK
# ═══════════════════════════════════════════
echo "🔌 CONNECTION CHECK"
echo "─────────────────────────────────────────────────────"
echo ""

# API URL check
API_URL=$(grep -oP "baseURL.*?['\"]http[^'\"]*" frontend/src/services/api.js 2>/dev/null | head -1)
if [ -n "$API_URL" ]; then
  echo "   ✅ Frontend API URL:"
  echo "      $API_URL"
else
  echo "   ⚠️  API URL not found in api.js"
fi
echo ""

# Backend URL check
echo "   ✅ Backend URL expected: http://localhost:8000/api"
echo ""

# Service call check
echo "   📊 Service methods (studentService.js):"
grep -oP "(getAll|getById|create|update|delete)" frontend/src/services/studentService.js 2>/dev/null | sort -u | sed 's/^/      ✅ /'
echo ""

# Store actions check
echo "   📊 Store actions (student.js):"
grep -oP "async function \K\w+" frontend/src/stores/student.js 2>/dev/null | sed 's/^/      ✅ /'
echo ""

# ═══════════════════════════════════════════
# PART 5: LIVE API TEST
# ═══════════════════════════════════════════
echo "🧪 LIVE API TEST"
echo "─────────────────────────────────────────────────────"
echo ""

if curl -s http://localhost:8000/api > /dev/null 2>&1; then
  echo "   ✅ Backend running on :8000"
  echo ""
  
  # Test login
  LOGIN=$(curl -s -X POST http://localhost:8000/api/auth/login \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"email":"super@ssms.et","password":"password"}')
  
  TOKEN=$(echo "$LOGIN" | grep -oP '"token":"\K[^"]*' | head -1)
  
  if [ -n "$TOKEN" ]; then
    echo "   ✅ Login works"
    echo "      Token: ${TOKEN:0:30}..."
    echo ""
    
    # Test each endpoint
    for ep in students teachers classes subjects attendance marks fees announcements; do
      R=$(curl -s "http://localhost:8000/api/$ep" \
        -H "Authorization: Bearer $TOKEN" \
        -H "Accept: application/json" 2>/dev/null)
      
      if echo "$R" | grep -q '"success":true'; then
        echo "   ✅ GET /$ep"
      else
        echo "   ⚠️  GET /$ep — Check"
      fi
    done
  else
    echo "   ❌ Login failed"
  fi
else
  echo "   ⚠️  Backend not running"
  echo "   Start: cd backend && php artisan serve"
fi
echo ""

# ═══════════════════════════════════════════
# SUMMARY
# ═══════════════════════════════════════════
echo "═══════════════════════════════════════════════════════"
echo "📊 SUMMARY"
echo "═══════════════════════════════════════════════════════"
echo ""

BACKEND_FILES=$(find backend/app/Models backend/app/Http/Controllers backend/routes -type f -name '*.php' 2>/dev/null | wc -l)
FRONTEND_FILES=$(find frontend/src/services frontend/src/stores frontend/src/views -type f \( -name '*.js' -o -name '*.vue' \) 2>/dev/null | wc -l)

echo "   Backend files:  $BACKEND_FILES"
echo "   Frontend files: $FRONTEND_FILES"
echo "   Empty files:    $(find frontend/src backend/app -type f \( -name '*.vue' -o -name '*.js' -o -name '*.php' \) -size 0 2>/dev/null | wc -l)"
echo ""

if [ "$(find frontend/src backend/app -type f \( -name '*.vue' -o -name '*.js' -o -name '*.php' \) -size 0 2>/dev/null | wc -l)" -eq 0 ]; then
  echo "   🎉 ALL FILES PRESENT"
else
  echo "   ⚠️  Some files are empty"
fi
echo ""
echo "═══════════════════════════════════════════════════════"

