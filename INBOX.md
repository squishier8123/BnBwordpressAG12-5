# DocsLib Inbox - Simple Learning Workflow

Your designated folder where everything gets automatically vectorized.

## The Folder

**`inbox/`** - Drop files here, run one command, they're vectorized.

## How It Works

### Step 1: Drop Files in Inbox

Put any of these in `inbox/`:
- 📄 **Markdown files** (.md)
- 📝 **Text files** (.txt)
- 🖼️ **Images** (.png, .jpg, .gif, .webp)

```
inbox/
  ├── python-guide.md
  ├── async-tutorial.txt
  ├── architecture-diagram.png
  ├── database-schema.jpg
  └── notes.md
```

### Step 2: Run Vectorize Command

```bash
python scripts/vectorize.py --category python --tags learning
```

That's it!

### Step 3: System Does Everything

The script automatically:
1. **Detects file types** - Markdown, text, images
2. **Asks questions** - For images, asks for descriptions
3. **Converts formats** - Text files to markdown, images to embedded documents
4. **Generates embeddings** - Vectorizes everything using sentence-transformers
5. **Stores files** - Saves in `docs/web/{category}/`
6. **Stores metadata** - Creates YAML frontmatter with all info
7. **Indexes** - Both keyword search (Whoosh) and semantic search (FAISS)
8. **Cleans up** - Moves processed files to `inbox/processed/`

### Step 4: Search Your Learning

```bash
# Semantic search
python scripts/search.py "your query" --category python --mode semantic

# Or browse what you just added
python scripts/manage.py list --category python
```

---

## Real Examples

### Example 1: Import Python Tutorials

```bash
# Put these in inbox/:
# - python-decorators.md
# - async-await-guide.txt
# - design-patterns.md

python scripts/vectorize.py --category python --tags tutorial,learning

# Result:
# ✓ python-decorators.md vectorized
# ✓ async-await-guide.txt vectorized
# ✓ design-patterns.md vectorized
#
# Search:
python scripts/search.py "how do decorators work" --mode semantic
```

### Example 2: Import Learning Materials with Images

```bash
# Put these in inbox/:
# - ml-flowchart.png
# - neural-network-diagram.jpg
# - intro-to-ml.md

python scripts/vectorize.py --category machine-learning --tags visual,learning

# For each image, you'll be asked:
#   Description: The basic architecture of a neural network

# Result:
# ✓ ml-flowchart.png vectorized with description
# ✓ neural-network-diagram.jpg vectorized with description
# ✓ intro-to-ml.md vectorized
```

### Example 3: Mix of Everything

```bash
python scripts/vectorize.py --category devops --tags docker,kubernetes --tags containers

# Markdown files → vectorized as-is
# Text files → converted to markdown, vectorized
# Images → stored with descriptions, vectorized
```

---

## What Happens to Your Files

### During Processing

Files are in `inbox/` with no frontmatter (or with frontmatter).

### After Processing

Files are moved to `inbox/processed/` and the system:
- Copies files to `docs/web/{category}/`
- Adds complete YAML frontmatter
- Stores metadata in `.metadata/index.json`
- Creates embeddings in `.metadata/embeddings/`

Your original files stay in `inbox/processed/` as backup.

---

## Supported File Types

| Type | Extension | What Happens |
|------|-----------|---|
| Markdown | `.md` | Parsed as-is, vectorized |
| Text | `.txt` | Converted to markdown, vectorized |
| Image | `.png` | Copied to docs/, embedded with description |
| Image | `.jpg` | Copied to docs/, embedded with description |
| Image | `.gif` | Copied to docs/, embedded with description |
| Image | `.webp` | Copied to docs/, embedded with description |

---

## Command Syntax

```bash
python scripts/vectorize.py --category {category} [--tags tag1 tag2...] [--status active|archived]
```

### Options

- `--category` (required): Where to organize docs (python, javascript, devops, etc.)
- `--tags` (optional): Tags to apply to all files (can use multiple)
  - `--tags learning` - single tag
  - `--tags learning --tags reference` - multiple tags
- `--status` (optional): Set to "active" (default) or "archived"

---

## Tips & Best Practices

1. **Organize by category** - Use consistent categories (python, javascript, databases, etc.)
2. **Use tags** - Tag with learning level, topic, or purpose
3. **Add descriptions** - For images, describe what they show
4. **Batch process** - Add multiple files, vectorize them all at once
5. **Check results** - After vectorizing, list them: `python scripts/manage.py list --category {category}`
6. **Archive when done** - After learning, archive docs: `python scripts/manage.py archive {doc_id}`

---

## Workflow Overview

```
Your Learning Material
        ↓
    inbox/
        ↓
  vectorize.py
    ↓  ↓  ↓
  Detect Format
    ↓  ↓  ↓
  Convert (if needed)
    ↓  ↓  ↓
  Ask Questions (descriptions)
    ↓  ↓  ↓
  Generate Embeddings
    ↓  ↓  ↓
  Store in docs/
    ↓  ↓  ↓
  Index (Whoosh + FAISS)
    ↓  ↓  ↓
  Move to inbox/processed/
    ↓
  Search & Learn!
```

---

## Troubleshooting

### "No files found in inbox"
- Check that inbox folder exists
- Make sure files aren't hidden (don't start with `.`)
- Supported formats: .md, .txt, .png, .jpg, .gif, .webp

### "Validation errors" after vectorizing
- Check that category is a simple word (no special characters)
- Make sure files have content
- Text files should have at least some text

### Files not appearing in search
- Make sure you vectorized them: `python scripts/manage.py list --category {your_category}`
- Try semantic search: `python scripts/search.py --category {your_category} --mode semantic`
- Rebuild index if needed: `python scripts/manage.py reindex`

### Images not showing descriptions
- When vectorizing images, make sure to enter a description when prompted
- Descriptions are stored and searchable

---

## Next Steps

1. Put some files in `inbox/`
2. Run: `python scripts/vectorize.py --category python --tags learning`
3. Search: `python scripts/search.py --category python --mode semantic`
4. View: `python scripts/manage.py list --category python`
5. Learn! 📚
