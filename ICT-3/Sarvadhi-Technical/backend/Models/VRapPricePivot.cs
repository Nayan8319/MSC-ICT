using System;
using System.Collections.Generic;

namespace backend.Models;
{
    public class RapPricePivotDto
    {
        public string Shape { get; set; }
        public string Color { get; set; }
        public decimal LowSize { get; set; }
        public decimal HighSize { get; set; }
        public int? IF { get; set; }
        public int? VVS1 { get; set; }
        public int? VVS2 { get; set; }
        public int? VS1 { get; set; }
        public int? VS2 { get; set; }
        public int? SI1 { get; set; }
        public int? SI2 { get; set; }
        public int? I1 { get; set; }
        public int? I2 { get; set; }
        public int? I3 { get; set; }
    }
}
