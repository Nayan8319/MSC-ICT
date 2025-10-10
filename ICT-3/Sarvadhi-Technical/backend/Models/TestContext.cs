using System;
using System.Collections.Generic;
using Microsoft.EntityFrameworkCore;

namespace backend.Models;

public partial class TestContext : DbContext
{
    public TestContext()
    {
    }

    public TestContext(DbContextOptions<TestContext> options)
        : base(options)
    {
    }


    public virtual DbSet<RapPrice> RapPrices { get; set; }

    public virtual DbSet<U1> U1s { get; set; }

    public virtual DbSet<VRapPricePivot> VRapPricePivots { get; set; }

    protected override void OnConfiguring(DbContextOptionsBuilder optionsBuilder)
#warning To protect potentially sensitive information in your connection string, you should move it out of source code. You can avoid scaffolding the connection string by using the Name= syntax to read it from configuration - see https://go.microsoft.com/fwlink/?linkid=2131148. For more guidance on storing connection strings, see https://go.microsoft.com/fwlink/?LinkId=723263.
        => optionsBuilder.UseSqlServer("Data Source=ADMIN;Initial Catalog=test;Integrated Security=True;Encrypt=True;Trust Server Certificate=True");

    protected override void OnModelCreating(ModelBuilder modelBuilder)
    {
        modelBuilder.Entity<RapPrice>(entity =>
        {
            entity.HasKey(e => e.Id).HasName("PK__RapPrice__3214EC075D656A46");

            entity.HasIndex(e => new { e.Shape, e.LowSize, e.HighSize, e.Color, e.Clarity }, "IX_RapPrices_Filter");

            entity.HasIndex(e => new { e.Shape, e.Color, e.Clarity, e.LowSize, e.HighSize }, "UQ_Rap").IsUnique();

            entity.Property(e => e.Clarity).HasMaxLength(10);
            entity.Property(e => e.Color).HasMaxLength(5);
            entity.Property(e => e.HighSize).HasColumnType("decimal(10, 2)");
            entity.Property(e => e.LowSize).HasColumnType("decimal(10, 2)");
            entity.Property(e => e.Shape).HasMaxLength(50);
        });

        modelBuilder.Entity<U1>(entity =>
        {
            entity
                .HasNoKey()
                .ToTable("u1");

            entity.Property(e => e.Id).HasColumnName("id");
            entity.Property(e => e.Name)
                .HasMaxLength(50)
                .IsUnicode(false)
                .HasColumnName("name");
        });

        modelBuilder.Entity<VRapPricePivot>(entity =>
        {
            entity.HasNoKey();
            entity.ToView("v_RapPricePivot");   // exact SQL view name
        });

        OnModelCreatingPartial(modelBuilder);
    }

    partial void OnModelCreatingPartial(ModelBuilder modelBuilder);
}
