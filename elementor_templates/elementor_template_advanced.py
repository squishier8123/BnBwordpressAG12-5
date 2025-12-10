#!/usr/bin/env python3
"""
Advanced Elementor Template Builder
====================================
Extended version with multiple template types and CLI interface.

Usage:
    python3 elementor_template_advanced.py --template cards --output cards.json
    python3 elementor_template_advanced.py --template hero --output hero.json
    python3 elementor_template_advanced.py --template features --output features.json
    python3 elementor_template_advanced.py --list
"""

import json
import argparse
from pathlib import Path
from datetime import datetime

# Import base classes from main builder
import sys
sys.path.insert(0, str(Path(__file__).parent))

# For demo purposes, redefine key classes (in production, would import from elementor_template_builder.py)


class ElementorWidget:
    """Base widget class."""
    def __init__(self, widget_type, settings=None):
        import uuid
        self.id = f"{widget_type}_{uuid.uuid4().hex[:8]}"
        self.elType = "widget"
        self.widgetType = widget_type
        self.settings = settings or {}
        self.elements = []

    def to_dict(self):
        return {
            "id": self.id,
            "elType": self.elType,
            "widgetType": self.widgetType,
            "settings": self.settings,
            "elements": self.elements
        }


class ElementorImage(ElementorWidget):
    def __init__(self, image_id, alt_text="", width="100%"):
        settings = {
            "image": {"id": image_id, "url": f"[IMAGE_ID_{image_id}]"},
            "image_size": "full",
            "image_custom_dimension": {"width": width},
            "link": {"url": ""},
            "align": "center",
            "caption": "",
            "alt": alt_text,
            "title_text": alt_text
        }
        super().__init__("image", settings)


class ElementorHeading(ElementorWidget):
    def __init__(self, text, level="h2", color="#333D29", size=24):
        settings = {
            "title": text,
            "header_size": level,
            "align": "center",
            "text_color": color,
            "typography_typography": "custom",
            "typography_font_size": {"unit": "px", "size": size},
            "typography_line_height": {"unit": "em", "size": 1.4}
        }
        super().__init__("heading", settings)


class ElementorText(ElementorWidget):
    def __init__(self, text, color="#656D4A", align="center", size=16):
        settings = {
            "editor": f"<p>{text}</p>",
            "text_color": color,
            "align": align,
            "typography_typography": "custom",
            "typography_font_size": {"unit": "px", "size": size},
            "typography_line_height": {"unit": "em", "size": 1.6}
        }
        super().__init__("text-editor", settings)


class ElementorButton(ElementorWidget):
    def __init__(self, text, url="#", color="#7F4F24", style="fill"):
        settings = {
            "text": text,
            "link": {"url": url, "is_external": False, "nofollow": False},
            "button_type": "default",
            "size": "md",
            "text_align": "center",
            "text_color": "#FFFFFF" if style == "fill" else color,
            "background_color": color if style == "fill" else "transparent",
            "border_type": "solid" if style == "outline" else "none",
            "border_color": color if style == "outline" else "transparent",
            "border_width": {"unit": "px", "size": 2} if style == "outline" else {"unit": "px", "size": 0},
            "padding": {"unit": "px", "top": "12", "right": "24", "bottom": "12", "left": "24"},
            "hover_animation": "grow"
        }
        super().__init__("button", settings)


class ElementorColumn:
    def __init__(self, width="33.33%"):
        import uuid
        self.id = f"column_{uuid.uuid4().hex[:8]}"
        self.elType = "column"
        self.settings = {"column_size": width, "content_width": "full"}
        self.elements = []

    def add_widget(self, widget):
        self.elements.append(widget.to_dict())

    def to_dict(self):
        return {
            "id": self.id,
            "elType": self.elType,
            "settings": self.settings,
            "elements": self.elements
        }


class ElementorRow:
    def __init__(self, gap="default"):
        import uuid
        self.id = f"row_{uuid.uuid4().hex[:8]}"
        self.elType = "row"
        self.settings = {"gap": gap, "columns_gap": {"unit": "px", "size": 20}}
        self.columns = []

    def add_column(self, column):
        self.columns.append(column)

    def to_dict(self):
        return {
            "id": self.id,
            "elType": "row",
            "settings": self.settings,
            "elements": [col.to_dict() for col in self.columns]
        }


class ElementorSection:
    def __init__(self, background_color="#F5F5F5", padding="40", min_height=None):
        import uuid
        self.id = f"section_{uuid.uuid4().hex[:8]}"
        self.elType = "section"
        settings = {
            "background_background": "classic",
            "background_color": background_color,
            "padding": {
                "unit": "px",
                "top": padding,
                "right": "20",
                "bottom": padding,
                "left": "20",
                "isLinked": False
            },
            "margin": {"unit": "px", "top": "0", "bottom": "0"},
            "columns_gap": {"unit": "px", "size": 20},
            "animation": "fadeInUp"
        }
        if min_height:
            settings["min_height"] = {"unit": "vh", "size": min_height}
        self.settings = settings
        self.rows = []

    def add_row(self, row):
        self.rows.append(row)

    def to_dict(self):
        elements = [row.to_dict() for row in self.rows]
        return {
            "id": self.id,
            "elType": self.elType,
            "settings": self.settings,
            "elements": elements
        }


class TemplateBuilder:
    """Factory for generating different template types."""

    BRAND_COLORS = {
        "primary_dark": "#414833",
        "primary_medium": "#333D29",
        "primary_light": "#656D4A",
        "secondary_light": "#A4AC86",
        "secondary_pale": "#C2C5AA",
        "secondary_warm": "#B6AD90",
        "secondary_tan": "#A68A64",
        "secondary_brown": "#936639",
        "secondary_dark_brown": "#7F4F24",
        "secondary_very_dark": "#582F0E"
    }

    @staticmethod
    def create_three_card_section(cards, bg_color="#F5F5F5"):
        """Create 3-card layout."""
        section = ElementorSection(bg_color, "40")
        row = ElementorRow()

        for idx, card in enumerate(cards):
            col = ElementorColumn("33.33%")

            col.settings.update({
                "background_color": "#FFFFFF",
                "border_border": "solid",
                "border_color": "#E8E8E8",
                "border_width": {"unit": "px", "size": 1},
                "border_radius": {"unit": "px", "top": "8", "right": "8", "bottom": "8", "left": "8"},
                "box_shadow": "0 8px 24px rgba(88, 47, 14, 0.15)",
                "animation": "fadeInUp",
                "animation_delay": f"{idx * 0.2}"
            })

            # Image
            img = ElementorImage(card["image_id"], card["title"])
            img.settings.update({
                "height": {"unit": "px", "size": 280},
                "object_fit": "cover",
                "border_radius": {"unit": "px", "top": "8", "right": "8", "bottom": "0", "left": "8"}
            })
            col.add_widget(img)

            col.settings["padding"] = {"unit": "px", "top": "0", "right": "20", "bottom": "20", "left": "20"}

            # Title
            title = ElementorHeading(card["title"], "h3", "#333D29", 22)
            col.add_widget(title)

            # Description
            desc = ElementorText(card["description"], "#656D4A", "center", 14)
            desc.settings["margin"] = {"unit": "px", "top": "10", "bottom": "15"}
            col.add_widget(desc)

            # Button
            btn = ElementorButton(card["button_text"], card["button_url"],
                                 card.get("button_color", TemplateBuilder.BRAND_COLORS["secondary_dark_brown"]), "fill")
            col.add_widget(btn)

            row.add_column(col)

        section.add_row(row)
        return [section.to_dict()]

    @staticmethod
    def create_hero_section(title, subtitle, image_id, cta_text, cta_url, bg_color="#F5F5F5"):
        """Create hero section with image, title, subtitle, and CTA."""
        section = ElementorSection(bg_color, "60", min_height=70)
        row = ElementorRow()

        # Content column (left)
        col_content = ElementorColumn("50%")
        col_content.settings.update({
            "padding": {"unit": "px", "top": "40", "right": "20", "bottom": "40", "left": "20"},
            "vertical_align": "middle"
        })

        title_widget = ElementorHeading(title, "h1", "#333D29", 48)
        col_content.add_widget(title_widget)

        subtitle_widget = ElementorText(subtitle, "#656D4A", "left", 18)
        subtitle_widget.settings["margin"] = {"unit": "px", "top": "20", "bottom": "30"}
        col_content.add_widget(subtitle_widget)

        btn = ElementorButton(cta_text, cta_url, TemplateBuilder.BRAND_COLORS["secondary_dark_brown"], "fill")
        col_content.add_widget(btn)

        # Image column (right)
        col_image = ElementorColumn("50%")
        col_image.settings.update({
            "background_color": "#FFFFFF",
            "padding": {"unit": "px", "top": "0", "right": "0", "bottom": "0", "left": "0"}
        })

        img = ElementorImage(image_id, title)
        img.settings.update({
            "height": {"unit": "px", "size": 500},
            "object_fit": "cover"
        })
        col_image.add_widget(img)

        row.add_column(col_content)
        row.add_column(col_image)
        section.add_row(row)

        return [section.to_dict()]

    @staticmethod
    def create_feature_grid(features, columns=3, bg_color="#FFFFFF"):
        """Create feature grid (2x2, 3x3, 4-column, etc.)."""
        section = ElementorSection(bg_color, "40")
        row = ElementorRow()

        col_width = f"{100 / columns:.2f}%"

        for idx, feature in enumerate(features):
            col = ElementorColumn(col_width)
            col.settings.update({
                "background_color": "#F5F5F5",
                "padding": {"unit": "px", "top": "30", "right": "20", "bottom": "30", "left": "20"},
                "text_align": "center",
                "animation": "fadeInUp",
                "animation_delay": f"{(idx % 3) * 0.15}"
            })

            # Icon or image (if provided)
            if "image_id" in feature:
                img = ElementorImage(feature["image_id"], feature["title"])
                img.settings.update({"height": {"unit": "px", "size": 80}})
                col.add_widget(img)

            # Title
            title = ElementorHeading(feature["title"], "h3", "#333D29", 20)
            col.add_widget(title)

            # Description
            desc = ElementorText(feature["description"], "#656D4A", "center", 14)
            desc.settings["margin"] = {"unit": "px", "top": "10", "bottom": "0"}
            col.add_widget(desc)

            row.add_column(col)

        section.add_row(row)
        return [section.to_dict()]

    @staticmethod
    def create_testimonial_grid(testimonials, bg_color="#F5F5F5"):
        """Create testimonial cards with quotes."""
        section = ElementorSection(bg_color, "40")
        row = ElementorRow()

        for idx, testimonial in enumerate(testimonials[:3]):  # Max 3 testimonials per row
            col = ElementorColumn("33.33%")
            col.settings.update({
                "background_color": "#FFFFFF",
                "padding": {"unit": "px", "top": "30", "right": "25", "bottom": "30", "left": "25"},
                "border_radius": {"unit": "px", "size": "8"},
                "box_shadow": "0 4px 12px rgba(0,0,0,0.08)",
                "animation": "fadeInUp",
                "animation_delay": f"{idx * 0.1}"
            })

            # Quote
            quote = ElementorText(f'"{testimonial["quote"]}"', "#333D29", "center", 16)
            quote.settings["italic"] = True
            quote.settings["margin"] = {"unit": "px", "top": "0", "bottom": "20"}
            col.add_widget(quote)

            # Author
            author = ElementorHeading(testimonial["author"], "h4", "#7F4F24", 16)
            col.add_widget(author)

            # Role
            role = ElementorText(testimonial.get("role", "Customer"), "#A4AC86", "center", 12)
            col.add_widget(role)

            row.add_column(col)

        section.add_row(row)
        return [section.to_dict()]


def generate_template(template_type, output_file=None):
    """Generate template based on type."""

    if template_type == "cards":
        cards = [
            {
                "image_id": 4680,
                "title": "Find Guided Hunts",
                "description": "Dial in top-rated hunts with expert guides who know every inch of Illinois whitetail country.",
                "button_text": "Find My Hunt",
                "button_url": "/browse-outfitters/",
                "button_color": "#E69500"
            },
            {
                "image_id": 4681,
                "title": "Local Vendors",
                "description": "Discover nearby shops, archery ranges, and trusted gear vendors all in one place.",
                "button_text": "Explore Vendors",
                "button_url": "/browse-vendors/",
                "button_color": "#7F4F24"
            },
            {
                "image_id": 4682,
                "title": "Buy & Sell Gear",
                "description": "Score deals on used hunting equipment. List your own gear and reach serious hunters.",
                "button_text": "Browse Gear",
                "button_url": "/marketplace/",
                "button_color": "#A4AC86"
            }
        ]
        elements = TemplateBuilder.create_three_card_section(cards)
        filename = output_file or "three_card_section.json"

    elif template_type == "hero":
        elements = TemplateBuilder.create_hero_section(
            title="Your Trophy Whitetail Awaits",
            subtitle="Connect with elite outfitters, expert guides, and premium hunting experiences across Illinois.",
            image_id=4680,
            cta_text="Start Your Hunt",
            cta_url="/browse-outfitters/"
        )
        filename = output_file or "hero_section.json"

    elif template_type == "features":
        features = [
            {"image_id": 4680, "title": "Expert Guides", "description": "Years of experience hunting Illinois whitetail."},
            {"image_id": 4681, "title": "Premium Gear", "description": "Top-quality archery equipment and supplies."},
            {"image_id": 4682, "title": "Community", "description": "Connect with serious hunters across Illinois."},
            {"title": "Fair Pricing", "description": "Transparent pricing with no hidden fees."},
            {"title": "Fast Shipping", "description": "Quick delivery on all gear orders."},
            {"title": "Expert Support", "description": "Dedicated customer success team."}
        ]
        elements = TemplateBuilder.create_feature_grid(features, columns=3)
        filename = output_file or "feature_grid.json"

    elif template_type == "testimonials":
        testimonials = [
            {"quote": "Found the perfect outfitter for my first big hunt!", "author": "Jake M.", "role": "Hunter"},
            {"quote": "The gear I found here is exactly what I needed.", "author": "Sarah T.", "role": "Archery Enthusiast"},
            {"quote": "Amazing community of like-minded hunters.", "author": "Mike P.", "role": "Veteran Hunter"}
        ]
        elements = TemplateBuilder.create_testimonial_grid(testimonials)
        filename = output_file or "testimonial_grid.json"

    else:
        print(f"Unknown template type: {template_type}")
        return False

    # Wrap in Elementor format
    data = {"settings": {}, "elements": elements}

    # Write to file
    with open(filename, "w") as f:
        json.dump(data, f, indent=2)

    print(f"✓ Generated: {filename}")
    print(f"  Size: {len(json.dumps(data))} bytes")
    print(f"  Elements: {len(elements)}")
    print(f"\n✓ Import via REST API:")
    print(f"  curl -X POST https://beardsandbucks.com/wp-json/wp/v2/elementor_library \\")
    print(f"    -H 'Authorization: Basic ...' \\")
    print(f"    -d @{filename}")

    return True


def main():
    parser = argparse.ArgumentParser(description="Elementor Template Generator")
    parser.add_argument("--template", choices=["cards", "hero", "features", "testimonials"],
                      help="Template type to generate")
    parser.add_argument("--output", help="Output filename")
    parser.add_argument("--list", action="store_true", help="List available templates")

    args = parser.parse_args()

    if args.list:
        print("Available templates:")
        print("  cards        - 3-card CTA section (hunts/vendors/gear)")
        print("  hero         - Full-width hero section")
        print("  features     - 3x2 feature grid")
        print("  testimonials - Testimonial cards")
        return

    if not args.template:
        parser.print_help()
        return

    generate_template(args.template, args.output)


if __name__ == "__main__":
    main()
