#!/bin/bash
#
# Claude Code Hook: Auto-Export Chat to Vector Database Inbox
# Triggered: On save/commit within Claude Code
# Purpose: Export conversation to DocsLib/inbox for vector database ingestion
#

# Configuration
INBOX_PATH="/mnt/c/Users/Geoff/OneDrive/Desktop/DocsLib/inbox"
PROJECT_NAME="Newbeards&Bucks12-5"
TIMESTAMP=$(date +"%Y-%m-%d_%H-%M-%S")
CHAT_EXPORT_NAME="claude-chat-${PROJECT_NAME}-${TIMESTAMP}.md"
CHAT_EXPORT_PATH="${INBOX_PATH}/${CHAT_EXPORT_NAME}"

# Ensure inbox exists
if [ ! -d "$INBOX_PATH" ]; then
  mkdir -p "$INBOX_PATH"
  echo "✓ Created inbox directory: $INBOX_PATH"
fi

# Create chat export header
cat > "$CHAT_EXPORT_PATH" << 'EOF'
# Claude Code Chat Export

**Auto-exported from Claude Code on save**

---

## Session Information
EOF

# Add metadata
echo "- **Project**: ${PROJECT_NAME}" >> "$CHAT_EXPORT_PATH"
echo "- **Exported**: ${TIMESTAMP}" >> "$CHAT_EXPORT_PATH"
echo "- **Location**: \`${INBOX_PATH}\`" >> "$CHAT_EXPORT_PATH"
echo "" >> "$CHAT_EXPORT_PATH"

# Add current working directory and git info if available
echo "## Context" >> "$CHAT_EXPORT_PATH"
echo "" >> "$CHAT_EXPORT_PATH"
echo "**Current Directory**: \`$(pwd)\`" >> "$CHAT_EXPORT_PATH"
echo "" >> "$CHAT_EXPORT_PATH"

# Add git status if in a git repo
if [ -d ".git" ]; then
  echo "**Last Commit**:" >> "$CHAT_EXPORT_PATH"
  echo "\`\`\`" >> "$CHAT_EXPORT_PATH"
  git log -1 --oneline >> "$CHAT_EXPORT_PATH" 2>/dev/null || echo "(Git info unavailable)" >> "$CHAT_EXPORT_PATH"
  echo "\`\`\`" >> "$CHAT_EXPORT_PATH"
  echo "" >> "$CHAT_EXPORT_PATH"
fi

# Add recent todos if they exist
if [ -f "TODO.md" ]; then
  echo "## Session Todos" >> "$CHAT_EXPORT_PATH"
  echo "" >> "$CHAT_EXPORT_PATH"
  echo "\`\`\`" >> "$CHAT_EXPORT_PATH"
  head -20 TODO.md >> "$CHAT_EXPORT_PATH"
  echo "\`\`\`" >> "$CHAT_EXPORT_PATH"
  echo "" >> "$CHAT_EXPORT_PATH"
fi

# Add CLAUDE.md summary if available
if [ -f "CLAUDE.md" ]; then
  echo "## Project Guidance (from CLAUDE.md)" >> "$CHAT_EXPORT_PATH"
  echo "" >> "$CHAT_EXPORT_PATH"
  echo "\`\`\`" >> "$CHAT_EXPORT_PATH"
  head -50 CLAUDE.md >> "$CHAT_EXPORT_PATH"
  echo "..." >> "$CHAT_EXPORT_PATH"
  echo "\`\`\`" >> "$CHAT_EXPORT_PATH"
  echo "" >> "$CHAT_EXPORT_PATH"
fi

# Add recent files modified
echo "## Recent Changes" >> "$CHAT_EXPORT_PATH"
echo "" >> "$CHAT_EXPORT_PATH"
echo "**Files Modified (Last 24 Hours)**:" >> "$CHAT_EXPORT_PATH"
echo "\`\`\`" >> "$CHAT_EXPORT_PATH"
find . -type f -mtime -1 -not -path './.git/*' -not -path './node_modules/*' -not -path './archive/*' 2>/dev/null | head -20 >> "$CHAT_EXPORT_PATH"
echo "\`\`\`" >> "$CHAT_EXPORT_PATH"
echo "" >> "$CHAT_EXPORT_PATH"

# Add timestamp note
echo "---" >> "$CHAT_EXPORT_PATH"
echo "" >> "$CHAT_EXPORT_PATH"
echo "**Note**: This is an auto-generated export for vector database ingestion." >> "$CHAT_EXPORT_PATH"
echo "Exported at: **${TIMESTAMP}**" >> "$CHAT_EXPORT_PATH"
echo "" >> "$CHAT_EXPORT_PATH"
echo "Vector Database: Ready for ingestion from \`${INBOX_PATH}\`" >> "$CHAT_EXPORT_PATH"

# Verify export was created
if [ -f "$CHAT_EXPORT_PATH" ]; then
  FILE_SIZE=$(du -h "$CHAT_EXPORT_PATH" | cut -f1)
  echo "✅ Chat exported: $CHAT_EXPORT_NAME (${FILE_SIZE})"
  echo "📂 Location: $CHAT_EXPORT_PATH"
  exit 0
else
  echo "❌ Failed to export chat"
  exit 1
fi
