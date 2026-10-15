#!/bin/bash

clear

echo "═══════════════════════════════════════════════════════"
echo "🎨 ALL LUCIDE ICONS IN PROJECT"
echo "📅 $(date)"
echo "═══════════════════════════════════════════════════════"
echo ""

# ═══════════════════════════════════════════
# CHECK INSTALLED
# ═══════════════════════════════════════════
if [ -d "node_modules/lucide-vue-next" ]; then
  VERSION=$(cat node_modules/lucide-vue-next/package.json | grep '"version"' | head -1 | cut -d'"' -f4)
  echo "✅ lucide-vue-next@$VERSION installed"
else
  echo "❌ lucide-vue-next NOT installed!"
  exit 1
fi
echo ""

# ═══════════════════════════════════════════
# FIND ALL ICON USAGES
# ═══════════════════════════════════════════
echo "📊 ICONS FOUND IN FILES:"
echo "─────────────────────────────────────────────────────"
echo ""

# All icons from imports
ALL_ICONS=$(grep -rhoP "from 'lucide-vue-next'" src/ 2>/dev/null | wc -l)
echo "Files with imports: $ALL_ICONS"
echo ""

# Get unique icon names
ICONS=$(grep -rhoP "import\s*\{[^}]+\}\s*from 'lucide-vue-next'" src/ 2>/dev/null | \
  grep -oP '\{[^}]+\}' | \
  tr ',' '\n' | \
  tr -d '{}' | \
  sed 's/^ *//;s/ *$//' | \
  grep -v '^$' | \
  sort -u)

echo "📊 UNIQUE ICONS USED ($(echo "$ICONS" | wc -l)):"
echo ""

# Print each icon with its usage count
while IFS= read -r icon; do
  [ -z "$icon" ] && continue
  
  # Count usage across all files
  COUNT=$(grep -rl "\b${icon}\b" src/ 2>/dev/null | wc -l)
  
  printf "   %-25s used in %2s files\n" "$icon" "$COUNT"
done <<< "$ICONS"
echo ""

# ═══════════════════════════════════════════
# VERIFY EACH ICON EXISTS IN LUCIDE
# ═══════════════════════════════════════════
echo "═══════════════════════════════════════════════════════"
echo "✅ VERIFICATION (Icon exists in Lucide?)"
echo "═══════════════════════════════════════════════════════"
echo ""

# Lucide exports file
LUCIDE_INDEX="node_modules/lucide-vue-next/dist/lucide-vue-next.js"

if [ -f "$LUCIDE_INDEX" ]; then
  VALID=0
  INVALID=0
  
  while IFS= read -r icon; do
    [ -z "$icon" ] && continue
    
    # Check if icon exists in lucide
    if grep -q "export.*\b${icon}\b" "$LUCIDE_INDEX" 2>/dev/null; then
      echo "   ✅ $icon"
      VALID=$((VALID+1))
    else
      echo "   ❌ $icon — NOT FOUND in Lucide!"
      INVALID=$((INVALID+1))
    fi
  done <<< "$ICONS"
  
  echo ""
  echo "   Valid:   $VALID"
  echo "   Invalid: $INVALID"
else
  echo "   ⚠️  Cannot verify — Lucide index not found"
fi
echo ""

# ═══════════════════════════════════════════
# SUMMARY
# ═══════════════════════════════════════════
echo "═══════════════════════════════════════════════════════"
echo "📊 SUMMARY"
echo "═══════════════════════════════════════════════════════"
echo ""

TOTAL_ICONS=$(echo "$ICONS" | wc -l)
echo "   Total unique icons: $TOTAL_ICONS"
echo "   Files using icons:  $ALL_ICONS"
echo ""
echo "═══════════════════════════════════════════════════════"

