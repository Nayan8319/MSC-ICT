using System;
using System.Collections.Generic;

namespace backend.Models;

public partial class RapPrice
{
    public int Id { get; set; }

    public string? Shape { get; set; }

    public string? Color { get; set; }

    public string? Clarity { get; set; }

    public decimal? LowSize { get; set; }

    public decimal? HighSize { get; set; }

    public int? Price { get; set; }
}
