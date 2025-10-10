using Microsoft.AspNetCore.Mvc;
using Microsoft.EntityFrameworkCore;
using backend.Models;

namespace backend.Controllers
{
    [Route("api/[controller]")]
    [ApiController]
    public class PriceController : ControllerBase
    {
        private readonly TestContext _context;
        public PriceController(TestContext context) => _context = context;

        // GET: api/price/pivot
        [HttpGet("pivot")]
        public async Task<ActionResult<IEnumerable<VRapPricePivot>>> GetPivot()
        {
            // just return the pivoted data from SQL view
            var data = await _context.VRapPricePivots
                .OrderBy(x => x.Shape)
                .ThenBy(x => x.LowSize)
                .ThenBy(x => x.Color)
                .ToListAsync();

            return data;
        }
    }
}
