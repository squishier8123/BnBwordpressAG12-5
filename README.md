# Beards & Bucks — Illinois Whitetail Hunting Directory + Used Gear Marketplace

A premium WordPress platform combining a Listeo-powered directory for hunting services (outfitters, lodging, gear vendors) with a Dokan-powered marketplace for used archery and hunting gear.

## 🎯 Quick Navigation

**Start Here**: [LATEST_PLAN_2025_12_07.md](LATEST_PLAN_2025_12_07.md) — Complete architecture, platform details, and roadmap

### Key Documents
- **[Architecture & System Design](LATEST_PLAN_2025_12_07.md#two-system-architecture)** — How Listeo + Dokan work together
- **[Current Page Structure](LATEST_PLAN_2025_12_07.md#current-site-structure-28-pages)** — All 28 existing WordPress pages
- **[Missing Pages Analysis](LATEST_PLAN_2025_12_07.md#missing-pages-analysis)** — Tier 1, 2, 3 priorities
- **[Setup Checklist](LATEST_PLAN_2025_12_07.md#setup-checklist)** — 5-phase verification and build plan
- **[Next Steps](LATEST_PLAN_2025_12_07.md#next-steps)** — Choose your direction

### WordPress Editing
- **[Quick Start Guide](docs/WORDPRESS_EDITING_QUICK_START.md)** — How to edit pages
- **[Brand Assets](docs/BRAND_ANALYSIS_2025_12_07.md)** — Color palette and design system

### MCP & Development
- **[WordPress MCP Patch Scripts](mcp-server-wordpress/)** — Auto-patching for AI editing
- **[Claude Code Rules](CLAUDE.md)** — Working methodology for this project

---

## 📊 Two-System Architecture

### System 1: Listeo (Directory for Services)
Hunting outfitters, lodging, gear vendors, archery shops
- Search, filters, reviews, booking system
- Vendor subscription tiers (Free → Pro packages)
- Multi-listing management
- Built-in map integration

### System 2: Dokan (Marketplace for Used Gear)
Individual sellers buying/selling archery and hunting gear
- Product inventory management
- Order fulfillment
- Commission-based revenue model
- Vendor dashboard with analytics

**Both systems share one WordPress user database.**

---

## 🌐 Current State

**Status**: Active Planning Phase
**Site URL**: https://beardsandbucks.com
**Current Pages**: 28 published pages
**Active Homepage**: Home 3 (ID: 4370)

**Technology Stack**:
- WordPress with Listeo theme
- Dokan multi-vendor plugin
- WooCommerce for product marketplace
- Elementor page builder
- Two active MCPs (Elementor + Respira WordPress)

---

## 🚀 Getting Started

### For Developers
1. Read [LATEST_PLAN_2025_12_07.md](LATEST_PLAN_2025_12_07.md) — establishes architecture
2. Review [CLAUDE.md](CLAUDE.md) — working methodology
3. Check [docs/WORDPRESS_EDITING_QUICK_START.md](docs/WORDPRESS_EDITING_QUICK_START.md) for page editing

### For Managing Content
1. WordPress Admin: https://beardsandbucks.com/wp-admin
2. User: jeff
3. Available pages documented in [LATEST_PLAN_2025_12_07.md](LATEST_PLAN_2025_12_07.md#current-site-structure-28-pages)

### For Next Phase Work
Choose one of three options:

**Option A**: Verify Existing Setup (30 mins)
- Confirm Store Dashboard & Store Listings pages exist for Dokan
- Check Dokan is properly configured

**Option B**: Build Missing Pages (2-3 hours)
- Create Browse by County page
- Create Vendor Pricing/Tiers page
- See [Missing Pages Analysis](LATEST_PLAN_2025_12_07.md#missing-pages-analysis)

**Option C**: Plan Dokan Customization (1 hour)
- Design gear-specific product fields
- Plan seller profile template
- See [Dokan Details](LATEST_PLAN_2025_12_07.md#dokan-platform-details)

---

## 🎨 Brand Requirements (Always Remember)

**Content**:
- ✅ Whitetail deer only (no other animals, no firearms)
- ✅ Compound bows featured prominently
- ✅ Premium, modern-outdoorsman aesthetic
- ✅ Golden-hour photography
- ✅ Illinois whitetail hunting focus

**Colors** (Use These Exactly):
- Primary: `#414833`, `#333D29`, `#656D4A`, `#A4AC86`, `#C2C5AA`
- Secondary: `#B6AD90`, `#A68A64`, `#936639`, `#7F4F24`, `#582F0E`

---

## 📁 Directory Structure

```
Newbeards&Bucks12-5/
├── LATEST_PLAN_2025_12_07.md ⭐ [PRIMARY SOURCE OF TRUTH]
├── README.md [This file]
├── CLAUDE.md [Working methodology]
├── .mcp.json [MCP configuration]
├── .env.example [Credential template]
├── custom-listing-card-css.css [Custom styling]
│
├── .claude/ [Claude Code settings]
├── docs/ [Documentation]
│   ├── WORDPRESS_EDITING_QUICK_START.md
│   ├── BRAND_ANALYSIS_2025_12_07.md
│   ├── reference/ [Page structure references]
│   └── [other docs]
│
├── mcp-server-wordpress/ [Patch scripts for WordPress MCP]
├── qa/ [Test framework]
├── tests/ [Test configurations]
│
└── brand-assets/ [Logo, color palette]
    ├── Logo/
    └── colors/
```

---

## 🔧 Configuration

### Environment Variables
Copy `.env.example` to `.env` and fill in credentials:
```bash
cp .env.example .env
# Edit .env with your actual credentials
```

⚠️ **Security**: Never commit `.env` to git. Use `.gitignore` rules.

### MCP Configuration
Two MCPs are configured in `.mcp.json`:
1. **elementor-mcp** — Page building automation
2. **respira-wordpress-mcp** — Safe AI editing

See `.claude/settings.local.json` for detailed permissions.

---

## 📚 Key Resources

| Document | Purpose |
|----------|---------|
| LATEST_PLAN_2025_12_07.md | Complete architecture & roadmap |
| CLAUDE.md | Development working guidelines |
| docs/WORDPRESS_EDITING_QUICK_START.md | How to edit pages |
| docs/BRAND_ANALYSIS_2025_12_07.md | Brand colors and design |
| DIRECTORY_AUDIT_REPORT_2025_12_07.md | System health & optimization notes |

---

## 🤔 FAQ

**Q: Where do I find the list of all pages?**
A: [LATEST_PLAN_2025_12_07.md#current-site-structure-28-pages](LATEST_PLAN_2025_12_07.md#current-site-structure-28-pages)

**Q: What pages are missing?**
A: [LATEST_PLAN_2025_12_07.md#missing-pages-analysis](LATEST_PLAN_2025_12_07.md#missing-pages-analysis)

**Q: How do I edit a page?**
A: [docs/WORDPRESS_EDITING_QUICK_START.md](docs/WORDPRESS_EDITING_QUICK_START.md)

**Q: What are Listeo and Dokan?**
A: [LATEST_PLAN_2025_12_07.md#platform-overview](LATEST_PLAN_2025_12_07.md#platform-overview)

**Q: What's the next step?**
A: [LATEST_PLAN_2025_12_07.md#next-steps](LATEST_PLAN_2025_12_07.md#next-steps)

---

## 📞 Support

For questions about:
- **Page editing**: See [docs/WORDPRESS_EDITING_QUICK_START.md](docs/WORDPRESS_EDITING_QUICK_START.md)
- **MCP setup**: See [mcp-server-wordpress/README.md](mcp-server-wordpress/README.md)
- **Architecture**: See [LATEST_PLAN_2025_12_07.md](LATEST_PLAN_2025_12_07.md)
- **Working methodology**: See [CLAUDE.md](CLAUDE.md)

---

**Last Updated**: December 7, 2025
**Status**: Active Planning Phase
**Next Decision Point**: Choose option A, B, or C from [Next Steps](LATEST_PLAN_2025_12_07.md#next-steps)
